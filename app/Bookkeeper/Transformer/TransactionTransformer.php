<?php  namespace Bookkeeper\Transformer;

use Bookkeeper\Transformer\Rules\RuleManager;

class TransactionTransformer
{

    /**
     * @var RuleManager
     */
    private $rules;

    public function __construct(RuleManager $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Collection of Eloquent Models
     *
     * @param $transactions
     * @return array
     */
    public function transform($OfxTransactions)
    {
        $return = [];
        foreach ($OfxTransactions as $transaction) {

            // Transform to eloquent model
            $transactionModel = $this->getTransactionModel($transaction);

            // Run rules on transaction
            $transactionRtn = $this->rules->run($transactionModel);

            if( is_array($transactionRtn) ) {
                $return = array_merge($return, $transactionRtn);
            } else {
                $return[] = $transactionRtn;
            }
        }

        throw new \Exception('TEMPORARY EXCEPTION TO VIEW LOGS');

        return $return;
    }

    public function getTransactionModel($ofxTransaction)
    {
        return new \Transaction(
            [
                'date'         => $ofxTransaction->date->format('Y-m-d H:i:s'),
                'payee'        => $ofxTransaction->name,
                'amount'       => $ofxTransaction->amount,
                'type'         => $ofxTransaction->type,
                'description'  => $ofxTransaction->memo
            ]
        );
    }
}