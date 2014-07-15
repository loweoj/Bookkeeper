<?php namespace Bookkeeper\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

class TransactionPresenter extends BasePresenter
{
    /**
     * @param \Transaction $transaction
     */
    public function __construct(\Transaction $transaction)
    {
        $this->resource = $transaction;
    }

    public function amount()
    {
        // return number_format($this->resource->amount, 2, '.', '');
    }


}