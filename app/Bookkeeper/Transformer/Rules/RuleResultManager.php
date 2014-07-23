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


    public function runResults($transaction, Array $ruleFields)
    {
        // replace field matches
        foreach( $ruleFields as $ruleKey => $ruleField) {
            if( starts_with($ruleKey, 'to_') && $ruleFields[$ruleKey] != '')
            {
                $field = str_replace('to_', '', $ruleKey);
                $transaction->{$field} = $ruleFields[$ruleKey];
            }
        }

        // create split transaction
        if(isset($ruleFields) && $ruleFields['splitJson'] != '')
        {
            return $this->splitManager->splitTransaction($transaction, $ruleFields['splitJson']);
        }

        // create an array to unify return type
        // If the result requires a split it would be an array.
        return $transaction;
    }

} 