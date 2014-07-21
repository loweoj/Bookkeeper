<?php  namespace Bookkeeper\Transformer\Rules;

use Illuminate\Database\Eloquent\Model;

class RuleManager {

    public function __construct()
    {
        // Sliming
        $this->rules = [
            new
        ];
    }

    /**
     * Run a set of rules on a single transaction
     *
     * @param Model $transaction
     * @return Model
     */
    public function run(Model $transaction)
    {
        foreach( $this->rules as $rule )
        {
            $rule->run($transaction);
        }
        return $transaction;
    }

} 