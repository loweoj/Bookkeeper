<?php  namespace Bookkeeper\Repo\Statements;

use Bookkeeper\Repo\Transaction\TransactionInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentStatement implements StatementInterface{

    protected $table = 'statements';

    /**
     * @var TransactionInterface
     */
    private $transaction;

    public function __construct(Model $statement, TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }


}