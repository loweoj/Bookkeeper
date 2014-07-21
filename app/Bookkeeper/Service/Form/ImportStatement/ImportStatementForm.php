<?php  namespace Bookkeeper\Service\Form\ImportStatement;

use Bookkeeper\Repo\Statements\StatementInterface;
use Bookkeeper\Service\Form\AbstractValidableForm;
use Bookkeeper\Service\Validation\ValidableInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use OfxParser\Parser;

class ImportStatementForm extends AbstractValidableForm {

    /**
     * @var StatementInterface
     */
    private $statement;

    /**
     * @var Parser
     */
    private $ofxParser;

    public function __construct(Parser $ofxParser, ValidableInterface $validator, StatementInterface $statement)
    {
        $this->validator = $validator;
        $this->statement = $statement;
        $this->ofxParser = $ofxParser;
    }

    public function import($input)
    {
        if( ! $this->valid($input) ) {
            return false;
        }

        try {
            // Parse file
            $ofx = $this->ofxParser->loadFromFile($input['file']->getRealPath());

            // Run rules
            $transactions = $ofx->BankAccount->Statement->transactions;

            $transactions = $this->transactionTransformer->transform($transactions);

            /////// EXAMPLE IMPLEMENTATION - procedural style
            /*

            if( str_contains('something',$transaction->payee) )
                splittransaction: category, stream, percentage





            *///////



            $this->statement->create([
                'start_date' => $ofx->BankAccount->Statement->startDate,
                'end_date' => $ofx->BankAccount->Statement->endDate,
                'transactions' => $transactions
            ]);

            return Response::json('success', 200);

        } catch (Exception $e) {
            // Could not find the file.
            print_r($e->getMessage());
            return Response::json($e->getMessage(), 400);
        }

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