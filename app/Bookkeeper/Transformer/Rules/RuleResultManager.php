<?php  namespace Bookkeeper\Transformer\Rules;

use Bookkeeper\Transformer\Split\SplitManager;
use Illuminate\Database\Eloquent\Model;

class RuleResultManager {

    /**
     * @var SplitManager
     */
    private $splitManager;

    /**
     * @param SplitManager $splitManager
     */
    public function __construct(SplitManager $splitManager)
    {
        $this->splitManager = $splitManager;
    }

    /**
     * @param array $transaction
     * @param array $rule
     * @return array
     */
    public function runResults(array $transaction, array $rule)
    {
        // replace field matches
        foreach( $rule as $ruleKey => $ruleField) {
            if( starts_with($ruleKey, 'to_') && $ruleField != '')
            {
                $field = str_replace('to_', '', $ruleKey);
                $transaction[$field] = $ruleField;
            }
        }

        // create split transaction
        if($rule['splitJson'] != '')
        {
            return $this->splitManager->splitTransaction($transaction, $rule['splitJson']);
        }

        return $transaction;
    }

} 