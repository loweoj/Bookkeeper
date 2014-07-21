<?php namespace Bookkeeper\Transformer\Rules;

interface RuleConditionInterface {

    /**
     * Perform a test on the given subject
     *
     * @return bool
     */
    public function test($subject);

} 