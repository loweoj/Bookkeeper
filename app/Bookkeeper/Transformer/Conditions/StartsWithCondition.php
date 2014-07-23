<?php  namespace Bookkeeper\Transformer\Conditions;

use Bookkeeper\Transformer\Rules\RuleConditionInterface;
use Illuminate\Support\Str;

class StartsWithCondition implements RuleConditionInterface{

    public function test($field, $value)
    {
        return Str::startsWith($field, $value);
    }
}