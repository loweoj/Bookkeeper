<?php

class Record extends BaseModel {

    protected $fillable = ['date', 'payee', 'description', 'money_in', 'money_out', 'transaction_id', 'category_id'];

    protected $dates = ['date'];

    public $softDelete = true;

    protected $appends = ['amount', 'amountType', 'recordType'];

    protected static $create_rules = [
        'date' => 'required',
        'payee' => 'required',
        'description' => 'required',
        'money_in' => 'required_without:money_out',
        'money_out' => 'required_without:money_in',
        'category_id' => 'required',
//        'stream_id'=> 'required'
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
    public function getAmountTypeAttribute()
    {
        return $this->recordType == 'income' ? 'credit' : 'debit';
    }

    public function getAmountAttribute()
    {
        return $this->money_in != null ? $this->money_in : $this->money_out;
    }

    public function getRecordTypeAttribute()
    {
        return $this->money_in != null ? 'income' : 'expense';
    }

    /**
     * Prepare the raw data for saving
     *
     * @param $data
     */
    public static function create(array $attributes)
    {
        if( isset($attributes['amount']) )
        {
            $attributes['money_in'] = $attributes['amount'];
            // Check if the amount is negative.
            if($attributes['amount'] < 0) {
                $attributes['money_out'] = abs($attributes['amount']);
                $attributes['money_in'] = null;
            }
            unset($attributes['amount']);
        }

        parent::create($attributes);
    }
}