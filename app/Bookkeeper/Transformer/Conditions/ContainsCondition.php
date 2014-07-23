<?php  namespace Bookkeeper\Transformer\Conditions;

use Bookkeeper\Transformer\Rules\RuleConditionInterface;
use Illuminate\Support\Str;

class ContainsCondition implements RuleConditionInterface{

    public function test($field, $value)
    {
        return Str::contains($field, $value);
    }
}