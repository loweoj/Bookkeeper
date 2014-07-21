<?php

namespace Bookkeeper\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class CategoryPresenter extends BasePresenter {

    /**
     * @param \Transaction $transaction
     */
    public function __construct(\Category $category)
    {
        $this->resource = $category;
    }

    public function type()
    {
        return ucfirst($this->resource->type);
    }

    public function nameWithCode()
    {
        return $this->code . ': ' . $this->name;
    }


} 