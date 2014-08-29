<?php

class BankAccount extends \Eloquent {

    protected $table = 'bank_accounts';

	protected $fillable = [
        'name',
        'description',
        'account_number',
        'sort_code'
    ];
}