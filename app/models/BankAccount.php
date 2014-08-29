<?php

class BankAccount extends BaseModel {

    protected $table = 'bank_accounts';

    protected $fillable = [
        'name',
        'description',
        'account_number',
        'sort_code'
    ];

    protected static $create_rules = [
        'account_number' => 'required',
        'sort_code'      => 'required',
        'name'           => 'required'
    ];

    public function transactions()
    {
        return $this->hasMany('Transaction', 'account_id');
    }
}