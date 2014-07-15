<?php

use McCool\LaravelAutoPresenter\PresenterInterface;

class Category extends BaseModel implements PresenterInterface {

    /**
     * @var array
     */
    protected $fillable = ['code', 'type', 'name', 'description'];

    /**
     * @var array
     */
    protected static $rules = [
        'code' => 'required|numeric|unique:categories',
        'name' => 'required',
        'type' => 'required'
    ];

    protected static $messages = [
        'code.min' => 'The code requires at least 3 digits'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return '\Bookkeeper\Presenters\CategoryPresenter';
    }

}