<?php

class Rule extends BaseModel
{
    /**
     * @var bool
     */
    public $softDelete = true;

    /**
     * @var array
     */
    // public $appends = ['conditions', 'split'];

    /**
     * @var string
     */
    protected $table = 'rules';

    /**
     * @var array
     */
    protected $fillable = ['title', 'conditionJson', 'conditionType', 'to_payee', 'to_category', 'to_stream', 'to_description', 'splitJson'];

    /**
     * @return mixed
     */
    public function getSplitJsonAttribute()
    {
        if( $this->attributes['splitJson'] != '')
            return json_decode($this->attributes['splitJson']);

        return $this->attributes['splitJson'];
    }

    /**
     * @return mixed
     */
    public function getConditionsAttribute()
    {
        if( $this->attributes['conditionJson'] != '')
            return json_decode($this->attributes['conditionJson']);

        return $this->attributes['conditionJson'];
    }

    /**
     * set conditionJson as JSON
     *
     * @param $value
     */
    public function setConditionJsonAttribute($value)
    {
        $this->attributes['conditionJson'] = $this->ensureJson($value);
    }

    /**
     * Set splitJson as JSON
     *
     * @param $value
     */
    public function setSplitJsonAttribute($value)
    {
        $this->attributes['splitJson'] = $this->ensureJson($value);
    }

    /**
     * Ensure a string is formatted as JSON
     *
     * @param $string
     * @return string
     */
    protected function ensureJson($string)
    {
        if (!$this->isJson($string))
            return json_encode($string);

        return $string;
    }

    /**
     * Check if a string is JSON
     *
     * @param $string
     * @return bool
     */
    protected function isJson($string)
    {
        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }
}