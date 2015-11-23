<?php  namespace Bookkeeper\Repo\BankAccount;

use Bookkeeper\Repo\Transaction\TransactionInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Validator;

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

    /**
     * Find a bank account by account number, or create one!
     *
     * @param array $account
     * @return bool|static
     */
    public function findOrCreate(array $account)
    {
        if ( ! isset($account['account-number'])) {
            return false;
        }

        // Find
        $acct = $this->findByAccountNumber($account['account-number']);

        // or create!
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

    /**
     * Find or create BankAccount, and add transactions
     *
     * @param $account
     * @return \BankAccount|EloquentBankAccount|bool|static
     */
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

    /**
     * Create transactions for a given bank account
     *
     * @param \BankAccount $acct
     * @param              $transactions
     * @return \BankAccount|bool
     */
    public function createTransactions(\BankAccount $acct, $transactions)
    {
        if (empty($transactions)) {
            return false;
        }

        $this->transaction->createForBankId($transactions, $acct->id);
        return $acct;
    }

    /**
     * Find a bank account by account number
     * @param $account
     * @return mixed
     */
    public function findByAccountNumber($account)
    {
        return $this->bankAccount->where('account_number', '=', $account)->first();
    }
}