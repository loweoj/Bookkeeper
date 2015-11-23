<?php namespace Bookkeeper\Commanding\Commands;

use Bookkeeper\Commanding\Base\CommandHandler;
use Bookkeeper\Repo\BankAccount\BankAccountInterface;
use Bookkeeper\Repo\Record\RecordInterface;
use Bookkeeper\Rules\RuleManager;
use Illuminate\Support\Collection;

class ImportStatementCommandHandler implements CommandHandler {

    /**
     * @var BankAccountInterface
     */
    private $bankRepo;

    /**
     * @var RecordInterface
     */
    private $recordRepo;
    /**
     * @var RuleManager
     */
    private $ruleManager;

    /**
     * @param BankAccountInterface $bankRepo
     * @param RecordInterface      $recordRepo
     */
    public function __construct(RuleManager $ruleManager, BankAccountInterface $bankRepo, RecordInterface $recordRepo)
    {
        $this->bankRepo = $bankRepo;
        $this->recordRepo = $recordRepo;
        $this->ruleManager = $ruleManager;
    }

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        $accountData = $command->accountData;
        $returnCollection = new Collection;

        foreach ($accountData as $i => $account) {

            if ($bankAccount = $this->bankRepo->findOrCreateWithTransactions($account)) {

                $transactions = $bankAccount->transactions;

//                dd($transactions);
//                if( empty($transactions)) {
//
//                }
                // Make draft records
                $draftRecords = $this->ruleManager->run($transactions->toArray());

                // Translate each modified transaction to a draft record
                foreach( $draftRecords as &$record)
                {
                    if (isset($record['id'])) {
                        $record['transaction_id'] = $record['id'];
                        unset($record['id']);
                    }
                    if (isset($record['updated_at'])) unset($record['updated_at']);
                    if (isset($record['created_at'])) unset($record['created_at']);
                    if (isset($record['deleted_at'])) unset($record['deleted_at']);
                    if (isset($record['reconciled'])) unset($record['reconciled']);
                }

                // create draft records!
                $draftRecords = $this->recordRepo->createDraftRecordsForAccount($draftRecords, $bankAccount->id);
                $returnCollection = $returnCollection->merge($draftRecords);
            }
        }
        return $returnCollection;
    }
}