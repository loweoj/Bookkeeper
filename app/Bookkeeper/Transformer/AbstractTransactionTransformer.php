<?php  namespace Bookkeeper\Transformer;

use Bookkeeper\Transformer\Rules\RuleManager;

abstract class AbstractTransactionTransformer implements TransactionTransformerInterface {

    /**
     * @var RuleManager
     */
    private $rules;

    /**
     * @param RuleManager $rules
     */
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
    public function transform($transactionsData)
    {
        $return = [];
        foreach ($transactionsData as $transaction) {

            // Transform to eloquent model
            $transactionModel = $this->getTransactionModel($transaction);

            // Run rules on transaction
            $transactionRtn = $this->rules->run($transactionModel);

            if (is_array($transactionRtn)) {
                $return = array_merge($return, $transactionRtn);
            } else {
                $return[] = $transactionRtn;
            }
        }

        return $return;
    }
}