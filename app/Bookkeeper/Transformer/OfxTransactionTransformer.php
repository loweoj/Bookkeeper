<?php  namespace Bookkeeper\Transformer;

class OfxTransactionTransformer extends AbstractTransactionTransformer {

    /**
     * Return a new \Transaction model for a set
     * of transaction data
     *
     * @param $ofxTransaction
     * @return mixed|\Transaction
     */
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