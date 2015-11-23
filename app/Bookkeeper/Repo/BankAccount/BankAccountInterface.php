<?php


namespace Bookkeeper\Repo\BankAccount;

interface BankAccountInterface {
    /**
     * Find a bank account by account number, or create one!
     *
     * @param array $account
     * @return bool|static
     */
    public function findOrCreate(array $account);

    /**
     * Find or create BankAccount, and add transactions
     *
     * @param $account
     * @return \BankAccount|EloquentBankAccount|bool|static
     */
    public function findOrCreateWithTransactions($account);

    /**
     * Create transactions for a given bank account
     *
     * @param \BankAccount $acct
     * @param              $transactions
     * @return \BankAccount|bool
     */
    public function createTransactions(\BankAccount $acct, $transactions);

    /**
     * Find a bank account by account number
     *
     * @param $account
     * @return mixed
     */
    public function findByAccountNumber($account);
}