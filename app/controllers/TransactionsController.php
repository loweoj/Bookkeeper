<?php

use Bookkeeper\Repo\Transaction\TransactionInterface;

class TransactionsController extends \BaseController {

    /**
     * @var TransactionInterface
     */
    private $transaction;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $categories = [
	        1 => 'Category One',
	        2 => 'Category Two',
	        3 => 'Category Three'
	    ];

        $transactions = $this->transaction->all();

	    return View::make('transactions.list')
	        ->with('transactions', $transactions)
	        ->with('categories', $categories);
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
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
