<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('login');
});


Route::get('transactions', function()
{

    $transactions = [
        [
            'id' => 1,
            'date' => Carbon::createFromTimestamp(strtotime('25-06-2013')),
            'name' => 'BBC Symphony Orchestra',
            'description' => 'Something',
            'type' => 'credit',
            'amount' => '500'
        ],
        [
            'id' => 3,
            'date' => Carbon::createFromTimestamp(strtotime('25-06-2013')),
            'name' => 'SINFONIETTA PRDTIN BGC PAYMENT 23049494',
            'description' => '',
            'type' => 'credit',
            'amount' => '560.25'
        ],
        [
            'id' => 4,
            'date' => Carbon::createFromTimestamp(strtotime('25-06-2014')),
            'name' => 'TGI Friday',
            'description' => '',
            'type' => 'debit',
            'amount' => '22.40'
        ],
        [
            'id' => 5,
            'date' => Carbon::createFromTimestamp(strtotime('01-06-2014')),
            'name' => 'PHILHARMONIA LTD BGC 200023',
            'description' => '',
            'type' => 'credit',
            'amount' => '146'
        ]
    ];
    return View::make('transactions')->with('transactions', $transactions);
});


Route::get('income', function()
{
    return View::make('transactions');
});


Route::get('expenses', function()
{
    return View::make('transactions');
});