<?php  namespace Bookkeeper\Transformer;

use Bookkeeper\Transformer\Rules\RuleManager;

class TransactionTransformer {

    /**
     * @var RuleManager
     */
    private $rules;

    public function __construct(RuleManager $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Collection of Eloquen Models
     *
     * @param $transactions
     * @return array
     */
    public function transform($transactions)
    {
        $return = [];
        foreach( $transactions as $transaction )
        {
            $return[] = $this->rules->run($transaction);
        }
        return $return;
    }

} 