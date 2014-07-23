<?php  namespace Bookkeeper\Transformer\Rules;

use Bookkeeper\Transformer\Conditions\ConditionFactory;
use Illuminate\Database\Eloquent\Model;

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
     * @param Model $transaction
     * @param       $dbRule
     * @return mixed
     */
    public function runConditions($transaction, $dbRule)
    {
        $conditionMethod = $dbRule->conditionType . "Conditions";
        $conditionResultsArray = $this->getConditionResults($transaction, $dbRule);
        return $this->{$conditionMethod}($conditionResultsArray);
    }

    /**
     * @param Model $transaction
     * @param       $dbRule
     * @return array
     */
    protected function getConditionResults($transaction, $dbRule)
    {
        $conditionResultsArray = [];
        foreach ($dbRule->conditions as $dbCondition) {
            $condition = $this->conditionFactory->make($dbCondition->match);
            $conditionResultsArray[] = $condition->test($transaction->{$dbCondition->field}, $dbCondition->value);
        }
        return $conditionResultsArray;
    }

    /**
     * @param array $conditionResultsArray
     * @return bool
     */
    protected function anyConditions(array $conditionResultsArray)
    {

        return array_search(true, $conditionResultsArray) == true;
    }

    /**
     * @param array $conditionResultsArray
     * @return bool
     */
    protected function allConditions(array $conditionResultsArray)
    {
        return array_search(false, $conditionResultsArray) === false;
    }
}