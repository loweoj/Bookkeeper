<?php  namespace Bookkeeper\Transformer\Rules;

use Bookkeeper\Repo\Rule\RuleInterface;
use DebugBar\DebugBar;
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

    public function __construct(RuleInterface $rulesRepo,  RuleConditionManager $conditionManager, RuleResultManager $resultManager)
    {
        $this->rulesRepo = $rulesRepo;
        $this->conditionManager = $conditionManager;
        $this->resultManager = $resultManager;

        // Fetch DB Rules
        $this->rules = $this->rulesRepo->all();
    }

    /**
     * Run the set of rules on a single transaction
     *
     * @param Model $transaction
     * @return array|Model
     * @throws \Exception
     */
    public function run(Model $transaction)
    {
        foreach( $this->rules as $rule )
        {
            // could cause issues running a rule on an array in future rules...?
            // $transaction is an array when it returns from runResults
            if ( $this->conditionManager->runConditions($transaction, $rule) )
            {
                $transaction = $this->resultManager->runResults($transaction, $rule);
                if(gettype($transaction) == 'array') {
                    dd($transaction);
                }
            }
        }

        return $transaction;
    }

} 