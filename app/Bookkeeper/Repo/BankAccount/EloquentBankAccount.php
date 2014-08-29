<?php  namespace Bookkeeper\Repo\BankAccount;

use Bookkeeper\Repo\Transaction\TransactionInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EloquentBankAccount implements BankAccountInterface {

    /**
     * @var Model
     */
    private $bankAccount;
    /**
     * @var Model
     */
    private $transaction;

    public function __construct(Model $bankAccount, TransactionInterface $transaction)
    {
        $this->bankAccount = $bankAccount;
        $this->transaction = $transaction;
    }

    public function findOrCreate(array $account)
    {
        if ( ! isset($account['account-number'])) {
            return false;
        }

        // Find ?
        $acct = $this->findByAccountNumber($account['account-number']);

        // Create!
        if ( ! $acct) {

            $atts = [
                'account_number' => $account['account-number'],
                'sort_code'      => $account['sort-code']
            ];

            if ( ! isset($account['name'])) {
                $time = new Carbon;
                $atts['name'] = 'Created At: ' . $time->format('Y-m-d H:i:s');
            }

            $acct = $this->bankAccount->create($atts);
            if ( ! $acct) {
                return false;
            }
        }

        // Return found/created account
        return $acct;
    }

    public function findOrCreateWithTransactions($account)
    {
        $acct = $this->findOrCreate($account);

        if ( ! $acct) {
            return false;
        }

        if ( ! isset($account['transactions']) || empty($account['transactions'])) {
            return false;
        }

        $acct = $this->createTransactions($acct, $account['transactions']);

        return $acct;
    }

    public function createTransactions(\BankAccount $acct, $transactions)
    {
        // Insert Transactions
        if (empty($transactions)) {
            return false;
        }

        $acctId = $acct->id;

        foreach ($transactions as &$transaction) {
            $transaction['account_id'] = $acctId;
        }

        $result = \DB::table('transactions')->insert($transactions);

        if( $result ) {
            return $acct;
        }
        return false;
    }

    public function findByAccountNumber($account)
    {
        return $this->bankAccount->where('account_number', '=', $account)->first();
    }
}