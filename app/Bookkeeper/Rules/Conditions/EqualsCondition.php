<?php  namespace Bookkeeper\Rules\Conditions;

class EqualsCondition implements RuleConditionInterface {

    public function test($field, $value)
    {
        return ($field == $value);
    }
}