<?php

namespace Bookkeeper\Repo\Transaction;

interface TransactionInterface {

    /**
     * Returns all resources
     *
     * @return mixed
     */
    public function all();

} 