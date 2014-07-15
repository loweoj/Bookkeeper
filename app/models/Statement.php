<?php

class Statement extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'statements';

    /**
     * @var array
     */
    protected $fillable = ['start_date', 'end_date'];

    /**
     * @var array
     */
    protected $dates = ['start_Date', 'end_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('Transaction');
    }
}