<?php  namespace Bookkeeper\Repo\Statement;

use Bookkeeper\Repo\Transaction\TransactionInterface;
use Illuminate\Database\Eloquent\Model;
use Statement;

class EloquentStatement implements StatementInterface {

    protected $table = 'statements';

    /**
     * @var TransactionInterface
     */
    private $transaction;

    /**
     * @param Model                $statement
     * @param TransactionInterface $transaction
     */
    public function __construct(Model $statement, TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @param $data
     * @return bool|Statement
     */
    public function create($data)
    {
        // Find and remove transactions from data
        if (isset($data['transactions'])) {
            $transactions = $data['transactions'];
            unset($data['transactions']);
        }

        // Create statement
        $statement = new Statement($data);

        // Save statement
        if ($statement->save()) {
            if (isset($transactions)) {
                $statement->transactions()->saveMany($transactions);
            }

            return $statement;
        }

        return false;
    }
}