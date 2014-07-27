<?php namespace Bookkeeper\Transformer;

use Bookkeeper\Transformer\Rules\RuleManager;

interface TransactionTransformerInterface {

    /**
     * @param RuleManager $rules
     */
    public function __construct(RuleManager $rules);

    /**
     * Collection of Eloquent Models
     *
     * @param $transactionsData
     * @return array
     */
    public function transform($transactionsData);

    /**
     * Return a new \Transaction model for a set
     * of transaction data
     *
     * @param $transactionData
     * @return mixed
     */
    public function getTransactionModel($transactionData);
}