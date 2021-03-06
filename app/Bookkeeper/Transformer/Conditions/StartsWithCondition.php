<?php  namespace Bookkeeper\Transformer\Conditions;

use Illuminate\Support\Str;

class StartsWithCondition implements RuleConditionInterface{

    public function test($field, $value)
    {
        return Str::startsWith($field, $value);
    }
}