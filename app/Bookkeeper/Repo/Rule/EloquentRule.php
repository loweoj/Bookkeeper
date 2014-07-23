<?php  namespace Bookkeeper\Repo\Rule;

use Illuminate\Database\Eloquent\Model;

class EloquentRule implements RuleInterface {

    /**
     * @var Model
     */
    private $rule;

    /**
     * @param Model $rule
     */
    public function __construct(Model $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Returns all of the Resources.

     * @return Model[]
     */
    public function all()
    {
        return $this->rule->all();
    }
}