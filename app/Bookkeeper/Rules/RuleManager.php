<?php  namespace Bookkeeper\Rules;

use Bookkeeper\Repo\Rule\RuleInterface;
use Illuminate\Database\Eloquent\Model;

class RuleManager {

    /**
     * @var RuleConditionManager
     */
    private $conditionManager;

    /**
     * @var RuleResultManager
     */
    private $resultManager;

    public function __construct(RuleInterface $rulesRepo, RuleConditionManager $conditionManager, RuleResultManager $resultManager)
    {
        $this->rulesRepo = $rulesRepo;
        $this->conditionManager = $conditionManager;
        $this->resultManager = $resultManager;

        // Fetch DB Rules
        $this->rules = $this->rulesRepo->allAsArray();
    }

    /**
     * Run rules on multiple transactions
     *
     * @param $transactions
     * @return array
     */
    public function run($transactions)
    {
        $return = [];
        foreach ($transactions as $transaction)
        {
            $result = $this->runSingle($transaction);

            // If the array has been split (is multidimensional)
            // then we merge it onto the current return array.
            if (isset($result[0]) && is_array($result[0])) {
                $return = array_merge($return, $result);
                continue;
            }
            // Otherwise we just add the transaction as a new key.
            $return[] = $result;
        }

        return $return;
    }

    /**
     * Run the set of rules on a single transaction
     *
     * @param Model $transaction
     * @return array|Model
     * @throws \Exception
     */
    public function runSingle($transaction)
    {
        foreach ($this->rules as $rule)
        {
            // Check we are handling an array rule here!
            if (gettype($rule) !== 'array' && $rule instanceof Model) {
                $rule = $rule->toArray();
            }

            if ($this->conditionManager->runConditions($transaction, $rule)) {
                $transaction = $this->resultManager->runResults($transaction, $rule);

                // Stop running rules if we have a split
                if (isset($transaction[0]) && is_array($transaction[0])) {
                    break;
                }
            }
        }

        return $transaction;
    }
}