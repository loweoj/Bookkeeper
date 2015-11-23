<?php

use Bookkeeper\Repo\Category\CategoryInterface;
use Bookkeeper\Repo\Record\RecordInterface;
use Bookkeeper\Repo\Transaction\TransactionInterface;

class TransactionsController extends \BaseController {

    /**
     * @var TransactionInterface
     */
    private $transaction;
    /**
     * @var CategoryInterface
     */
    private $category;

    public function __construct(TransactionInterface $transaction, RecordInterface $record, CategoryInterface $category)
    {
        $this->transaction = $transaction;
        $this->record = $record;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get categories
        $expenseCategories = $this->category->getDropdownArray('expense');
        $incomeCategories = $this->category->getDropdownArray('income');

        // Get all draft transactions/records
        $transactions = $this->record->getDrafts();

        // Add categories
        $transactions->map(function ($record) use ($incomeCategories, $expenseCategories) {
            if ($record->type == 'income') {
                $record->categoriesArray = $incomeCategories;
            } else {
                $record->categoriesArray = $expenseCategories;
            }
        });

        return View::make('transactions.list')
                   ->with('transactions', $transactions)
                   ->with('expenseCats', $expenseCategories)
                   ->with('incomeCats', $incomeCategories);
    }

    public function import()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
