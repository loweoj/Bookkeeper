<?php  namespace Bookkeeper\Repo\Transaction;

use Illuminate\Database\Eloquent\Model;

class EloquentTransaction implements TransactionInterface {

    protected $table = 'transactions';

    /**
     * @var
     */
    private $transaction;

    public function __construct(Model $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Returns all of the Resources.
     *
     * @return Model[]
     */
    public function all()
    {
        return $this->transaction
            ->with('statement')
            ->orderBy('date', 'desc')
            ->get();
    }

} 