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

/**
 * Transactions List
 */
Route::get('transactions', 'TransactionsController@index');

/**
 * Statement Import Handler
 */
Route::post('statements/import', 'StatementsController@import');

/**
 * Records Resource
 */
Route::resource('records', 'RecordController');


Route::resource('/settings/categories', 'CategoriesController');
Route::resource('/settings/streams', 'StreamsController');

/**
 * Temp Income
 */
Route::get('income', function()
{
    return View::make('transactions');
});

/**
 * Temp Expenses
 */
Route::get('expenses', function()
{
    return View::make('transactions');
});