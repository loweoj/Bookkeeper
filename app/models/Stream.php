<?php

class Stream extends BaseModel {

    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['name', 'description'];

    protected static $create_rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function records()
    {
        return $this->hasMany('Record');
    }

}