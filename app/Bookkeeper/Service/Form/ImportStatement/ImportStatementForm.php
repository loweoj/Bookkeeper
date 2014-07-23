<?php  namespace Bookkeeper\Service\Form\ImportStatement;

use Bookkeeper\Repo\Statements\StatementInterface;
use Bookkeeper\Service\Form\AbstractValidableForm;
use Bookkeeper\Service\Validation\ValidableInterface;
use Bookkeeper\Transformer\TransactionTransformer;
use \Exception;
use \Response;
use Illuminate\Database\Eloquent\Model;
use OfxParser\Parser;

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
     * @var TransactionTransformer
     */
    private $transactionTransformer;

    public function __construct(TransactionTransformer $transactionTransformer, Parser $ofxParser, ValidableInterface $validator, StatementInterface $statement)
    {
        $this->validator = $validator;
        $this->statement = $statement;
        $this->ofxParser = $ofxParser;
        $this->transactionTransformer = $transactionTransformer;
    }

    public function import($input)
    {
        // valid() adds validation error message.
        if( ! $this->valid($input) ) {
            return false;
        }

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
        /*

        $this->statement->create([
            'start_date' => $ofx->BankAccount->Statement->startDate,
            'end_date' => $ofx->BankAccount->Statement->endDate,
            'transactions' => $transactions
        ]);

        return Response::json('success', 200);
        */



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