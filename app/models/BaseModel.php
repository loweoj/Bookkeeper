<?php

class BaseModel extends \Eloquent {

    /**
     * Error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Validation rules for model creation
     *
     * @var Array
     */
    protected static $create_rules = [];

    /**
     * Validation rules for modeul updating
     *
     * @var Array
     */
    protected static $update_rules = [];

    /**
     * Custom messages
     *
     * @var Array
     */
    protected static $messages = [];

    /**
     * Validator instance
     *
     * @var Illuminate\Validation\Validators
     */
    protected $validator;

    public function __construct(array $attributes = [], Validator $validator = null)
    {
        parent::__construct($attributes);

        $this->validator = $validator ?: \App::make('validator');
    }

    /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            return $model->validate();
        });
    }

    /**
     * Validates current attributes against rules
     */
    public function validate()
    {
        // If the model exists and the update rules are populated, use them.
        $rules = ($this->exists && !empty(static::$update_rules)) ? static::$update_rules : static::$create_rules;

        $v = $this->validator->make($this->attributes, $rules, static::$messages);

        if ($v->passes())
        {
            return true;
        }

        $this->setErrors($v->messages());

        return false;
    }

    /**
     * Set error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Retrieve error message bag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Inverse of wasSaved
     */
    public function hasErrors()
    {
        return ! empty($this->errors);
    }
}