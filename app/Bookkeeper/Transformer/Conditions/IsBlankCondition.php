<?php  namespace Bookkeeper\Transformer\Conditions;

use Bookkeeper\Transformer\Rules\RuleConditionInterface;

class IsBlankCondition implements RuleConditionInterface{
    
    public function test($field, $value)
    {
        return ($field == '');
    }
}