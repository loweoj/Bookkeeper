<?php  namespace Bookkeeper\Transformer;

class CsvTransactionTransformer extends AbstractTransactionTransformer {

    /**
     * Return a new \Transaction model for a set
     * of transaction data
     *
     * @param $transactionData
     * @return mixed
     */
    public function getTransactionModel($transactionData)
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