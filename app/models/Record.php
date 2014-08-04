<?php

class Record extends BaseModel {

    protected $fillable = [
        'date',
        'payee',
        'amount',
        'description',
        'type',
        'transaction_id',
        'category_id',
        'stream_id'
    ];

    protected $dates = ['date'];

    public $softDelete = true;

    // protected $appends = ['amount', 'amountType', 'recordType'];

    protected static $create_rules = [
        'date' => 'required',
        'payee' => 'required',
        'description' => 'required',
        'amount' => 'required',
        'type' => 'required',
        'category_id' => 'required',
        'stream_id'=> 'required',
        'transaction_id' => 'required'
    ];

    public function category()
    {
        return $this->belongsTo('Category');
    }

    public function stream()
    {
        return $this->belongsTo('Stream');
    }

    public function transaction()
    {
        return $this->belongsTo('Transaction');
    }

    /**
     * @return string
     */
//    public function getAmountTypeAttribute()
//    {
//        return $this->recordType == 'income' ? 'credit' : 'debit';
//    }

//    public function getAmountAttribute()
//    {
//        return $this->money_in != null ? $this->money_in : $this->money_out;
//    }

//    public function getRecordTypeAttribute()
//    {
//        return $this->money_in != null ? 'income' : 'expense';
//    }

}