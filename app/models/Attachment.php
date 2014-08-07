<?php

class Attachment extends BaseModel
{

    protected $fillable = [
        'description',
        'filepath',
        'record_id'
    ];

    protected static $create_rules = [
        'filepath' => 'required|mimes:pdf,jpg,png,gif'
    ];

    protected static $messages = [
        'filepath.mimes' => 'The attachment must be a pdf, jpg, png or gif!'
    ];


    public function record()
    {
        return $this->belongsTo('Record');
    }
}