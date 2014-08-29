<?php

use McCool\LaravelAutoPresenter\PresenterInterface;

class Transaction extends BaseModel implements PresenterInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * @var array
     */
    protected $fillable = ['date', 'payee', 'description', 'amount', 'type', 'reconciled', 'statement_id', 'account_id'];

    /**
     * @var array
     */
    protected $dates = ['date'];

    /**
     * Enable soft deleteing on this model
     *
     * @var bool
     */
    protected $softDelete = true;

    protected static $create_rules = [
        'date'        => 'required',
        'payee'       => 'required',
        'description' => 'required',
        'amount'      => 'required'
    ];

    /**
     * @var array
     */
    protected $appends = ['amount_type'];

    public static function boot()
    {
        parent::boot();
        /*
        static::creating(function($post)
        {
            $post->created_by = Auth::user()->id;
            $post->updated_by = Auth::user()->id;
        });

        static::updating(function($post)
        {
            $post->updated_by = Auth::user()->id;
        });
        */
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statement()
    {
        return $this->belongsTo('Statement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bankAccount()
    {
        return $this->belongsTo('BankAccount', 'account_id');
    }

    /**
     * @return string
     */
    public function getAmountTypeAttribute()
    {
        return $this->amount > 0 ? 'credit' : 'debit';
    }

    /**
     * @return string
     */
    public function getPresenter()
    {
        return 'Bookkeeper\Presenters\TransactionPresenter';
    }
}