<?php  namespace Bookkeeper\Rules\Conditions;

class IsBlankCondition implements RuleConditionInterface{
    
    public function test($field, $value)
    {
        return ($field == '');
    }
}