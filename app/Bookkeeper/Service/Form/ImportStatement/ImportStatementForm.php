<?php  namespace Bookkeeper\Service\Form\ImportStatement;

use Bookkeeper\Repo\Statement\StatementInterface;
use Bookkeeper\Service\Form\AbstractValidableForm;
use Bookkeeper\Service\Validation\ValidableInterface;
use Bookkeeper\Transformer\TransactionTransformerInterface;
use OfxParser\Parser;
use Response;

class ImportStatementForm extends AbstractValidableForm {

    /**
     * @var
     */
    protected $transactions;

    /**
     * @var StatementInterface
     */
    private $statement;

    /**
     * @var Parser
     */
    private $ofxParser;

    /**
     * @var TransactionTransformerInterface
     */
    private $transactionTransformer;

    public function __construct(TransactionTransformerInterface $transformer, Parser $ofxParser, ValidableInterface $validator, StatementInterface $statement)
    {
        $this->validator = $validator;
        $this->statement = $statement;
        $this->ofxParser = $ofxParser;
        $this->transactionTransformer = $transformer;
//        $this->statementParser = $statementParser;
    }

    public function import($input)
    {
        // valid() adds validation error message.
        if ( ! $this->valid($input)) {
            return false;
        }

        // get file type and get a file parser
        // parse the file and get transactions

//        try {
        // Parse file
        $ofx = $this->ofxParser->loadFromFile($input['file']->getRealPath());

        // Run rules
        $transactions = $ofx->BankAccount->Statement->transactions;

        $transactions = $this->transactionTransformer->transform($transactions);

        $this->transactions = $transactions;

//        } catch (Exception $e) {
//            $this->errors()->add('data', 'There was an error importing your data: ' . $e->getMessage());
//            dd($e);
//            return false;
//        }

        $statement = $this->statement->create([
            'start_date'   => $ofx->BankAccount->Statement->startDate,
            'end_date'     => $ofx->BankAccount->Statement->endDate,
            'transactions' => $transactions
        ]);

        if ($statement) {
            return Response::json('success', 200);
        }

        return Response::json('error', 200);
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

//    protected function createTransactions(Model $statement, array $transactions)
//    {
//
//        // Move into REPO
//        $insertTransactions = [];
//        foreach($ofx->BankAccount->Statement->transactions as $transaction) {
//            $insertTransactions[] = [
//                'date'      => $transaction->date->format('Y-m-d H:i:s'),
//                'payee'     => $transaction->payee,
//                'amount'    => $transaction->amount,
//                'type'      => $transaction->type,
//                'statement_id' => $newStatement->id,
//                'created_at' => new DateTime,
//                'updated_at' => new DateTime
//            ];
//        }
//
//        // Create transactions in one fell swoop!
//        Transaction::insert($insertTransactions);
//    }

}