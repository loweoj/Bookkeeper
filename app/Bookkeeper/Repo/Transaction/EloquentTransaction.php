<?php  namespace Bookkeeper\Repo\Transaction;

use Illuminate\Database\Eloquent\Model;
use Validator;

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

    /**
     * @param $transactionData
     * @param $bankID
     * @return void
     */
    public function createForBankId($transactionData, $bankID)
    {
        foreach ($transactionData as $key => &$transaction) {

            if( ! $this->validateUnique($transaction)) {
                // Remove the transaction
                unset($transactionData[$key]);
                continue;
            }
            // Add the bank account id
            $transaction['account_id'] = $bankID;
        }

        // If we have transactions, let's insert them
        if( ! empty($transactionData)) {
            \DB::table('transactions')->insert($transactionData);
        }
    }

    /**
     * Validate a transaction is unique by checking payee, amount and date
     * @param $transaction
     * @return int
     */
    public function validateUnique($transaction)
    {
        $verifier = Validator::getPresenceVerifier();
        return $verifier->getCount(
                $this->transaction->getTable(), 'payee', $transaction['payee'], null, null, [
                    'amount' => $transaction['amount'],
                    'date' => $transaction['date']
                ]
            ) == 0;
    }
}