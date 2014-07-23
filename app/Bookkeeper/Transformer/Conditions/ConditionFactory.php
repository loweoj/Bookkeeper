<?php  namespace Bookkeeper\Transformer\Conditions;

class ConditionFactory {

    public function make($name)
    {
        $className = "Bookkeeper\\Transformer\\Conditions\\" . ucfirst($name) . "Condition";
        return new $className;
    }
} 