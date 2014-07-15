<?php

class Record extends Eloquent {

    protected $table = "records";

    protected $fillable = ['']

    /**
     * Prepare the raw data for saving
     *
     * @param $data
     */
    public static function create(array $attributes)
    {
        $attributes['money_in'] = $attributes['amount'];

        // Check if the amount is negative.
        if(isset($attributes['amount']) && $attributes['amount'] < 0) {
            $attributes['money_out'] = abs($attributes['amount']);
            $attributes['money_in'] = null;
        }
        unset($attributes['amount']);
        dd($attributes);

        parent::create($attributes);
    }
}