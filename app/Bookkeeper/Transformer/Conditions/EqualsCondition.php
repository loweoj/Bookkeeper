<?php  namespace Bookkeeper\Transformer\Conditions;

use Bookkeeper\Transformer\Rules\RuleConditionInterface;

class EqualsCondition implements RuleConditionInterface {

    public function test($field, $value)
    {
        return ($field == $value);
    }
}