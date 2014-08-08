<?php

class Attachment extends BaseModel
{

    protected $fillable = [
        'description',
        'filepath',
        'thumbpath',
        'original_name',
        'record_id'
    ];

    // NB. We can't validate a mime type here, because
    // filepath is a string and not an instance of SplFile!
    protected static $create_rules = [
        'record_id' => 'required',
        'filepath' => 'required',
        'original_name' => 'required'
    ];

    public function record()
    {
        return $this->belongsTo('Record');
    }

    /**
     * Convert the thumb path into an image response
     */
    public function getThumbAttribute()
    {
        return basename($this->thumbpath);
    }

    public function getNameAttribute()
    {
        return $this->original_name;
    }

}