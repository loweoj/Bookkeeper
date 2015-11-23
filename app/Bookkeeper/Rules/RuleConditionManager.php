<?php  namespace Bookkeeper\Rules;

use Bookkeeper\Rules\Conditions\ConditionFactory;

class RuleConditionManager {

    /**
     * @var ConditionFactory
     */
    private $conditionFactory;

    /**
     * @param ConditionFactory $conditionFactory
     */
    public function __construct(ConditionFactory $conditionFactory)
    {
        $this->conditionFactory = $conditionFactory;
    }

    /**
     * @param array $transaction
     * @param array $dbRule
     * @return mixed
     */
    public function runConditions(array $transaction, array $dbRule)
    {
        // The method we want to call (any/all?)
        $conditionMethod = $dbRule['conditionType'] . "Conditions";

        // Transform each condition into an array of false/true values
        $conditionResultsArray = $this->getConditionResults($transaction, $dbRule);

        // Test the condition type (any/all) for true values
        return $this->{$conditionMethod}($conditionResultsArray);
    }

    /**
     * @param array $transaction
     * @param array $dbRule
     * @return array
     */
    protected function getConditionResults(array $transaction, array $dbRule)
    {
        $conditionResultsArray = [];
        foreach ($dbRule['conditions'] as $dbCondition) {

            // NB. dbCondition is a json_decoded stdClass
            if (gettype($dbCondition) !== 'object') {
                throw new \InvalidArgumentException('Condition should be of type object, ' . gettype($dbCondition) . ' given');
            }

            // Make a new condition object
            $condition = $this->conditionFactory->make($dbCondition->match);

            // Test the condition
            $conditionResultsArray[] = $condition->test(strtoupper($transaction[$dbCondition->field]), strtoupper($dbCondition->value));
        }

        return $conditionResultsArray;
    }

    /**
     * Check we have at least one true value in the array
     *
     * @param array $conditionResultsArray
     * @return bool
     */
    protected function anyConditions(array $conditionResultsArray)
    {
        return array_search(true, $conditionResultsArray) !== false;
    }

    /**
     * Check we have no false values, and therefore all true values
     *
     * @param array $conditionResultsArray
     * @return bool
     */
    protected function allConditions(array $conditionResultsArray)
    {
        return array_search(false, $conditionResultsArray) === false;
    }
}