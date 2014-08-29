<?php  namespace Bookkeeper\Repo\BankAccount;

interface BankAccountInterface {

    /**
     * @param array $account
     */
    public function findOrCreate(array $account);

} 