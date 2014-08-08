<?php

class Record extends BaseModel
{

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

    protected static $create_rules = [
        'date'        => 'required',
        'payee'       => 'required',
        'description' => 'required',
        'amount'      => 'required',
        'type'        => 'required',
        'category_id' => 'required',
        'stream_id'   => 'required'
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

    public function attachment()
    {
        return $this->hasOne('Attachment');
    }

    public function hasAttachment()
    {
        return (bool) $this->attachment;
    }

    /**
     * @return string
     */
    public function getAmountTypeAttribute()
    {
        return $this->type == 'income' ? 'credit' : 'debit';
    }

    /**
     * @param $value
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon\Carbon::createFromFormat('d/m/Y', $value);
    }
}