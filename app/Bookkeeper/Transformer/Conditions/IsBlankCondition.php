<?php  namespace Bookkeeper\Transformer\Conditions;

class IsBlankCondition implements RuleConditionInterface{
    
    public function test($field, $value)
    {
        return ($field == '');
    }
}