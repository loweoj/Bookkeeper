<?php  namespace Bookkeeper\Rules\Conditions;

class ConditionFactory {

    public function make($name)
    {
        $className = "Bookkeeper\\Rules\\Conditions\\" . ucfirst($name) . "Condition";
        return new $className;
    }
} 