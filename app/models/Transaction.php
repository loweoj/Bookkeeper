<?php

use McCool\LaravelAutoPresenter\PresenterInterface;

class Transaction extends Eloquent implements PresenterInterface{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * @var array
     */
    protected $fillable = ['date', 'payee', 'description', 'amount', 'type', 'reconciled', 'statement_id'];

    /**
     * @var array
     */
    protected $dates = ['date'];

    /**
     * @var array
     */
    protected $appends = ['amount_type'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($post)
        {
            $post->created_by = Auth::user()->id;
            $post->updated_by = Auth::user()->id;
        });

        static::updating(function($post)
        {
            $post->updated_by = Auth::user()->id;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statement()
    {
        return $this->hasOne('Statement');
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