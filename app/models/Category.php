<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use McCool\LaravelAutoPresenter\PresenterInterface;

class Category extends BaseModel implements PresenterInterface {

    /**
     * Enable soft deleting on model
     */
    use SoftDeletingTrait;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $fillable = ['code', 'type', 'name', 'description'];

    /**
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * Validation rules when creating
     *
     * @var array
     */
    protected static $create_rules = [
        'code' => 'required|numeric|unique:categories',
        'name' => 'required',
        'type' => 'required'
    ];

    /**
     * Validation rules when updating
     *
     * @var array
     */
    protected static $update_rules = [
        'code' => 'required|numeric',
        'name' => 'required',
        'type' => 'required'
    ];

    /**
     * Validation messages
     *
     * @var array
     */
    protected static $messages = [
        'code.min' => 'The code requires at least 3 digits'
    ];

    public function records()
    {
        return $this->hasMany('Record');
    }

    public function getNameWithCodeAttribute()
    {
        return $this->code . ': ' . $this->name;
    }

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