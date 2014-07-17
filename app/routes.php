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


// Route::resource('/settings/categories', 'CategoriesController');
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



/**
 * Cribbbs
 *
 * The routes to create a Cribbb
 */
Route::get('categories', ['uses' => 'CategoriesController@index', 'as' => 'categories.index']);
Route::post('categories', ['uses' => 'CategoriesController@store', 'as' => 'categories.create']);
Route::post('categories/edit/{category}', ['uses' => 'CategoriesController@update', 'as' => 'categories.update']);
Route::post('categories/delete/{category}', ['uses' => 'CategoriesController@delete', 'as' => 'categories.delete']);

    /**
     * Display a listing of the resource.
     * GET /categories

     * store new category
     * POST /categories

     * Show the form for editing the specified resource.
     * GET /categories/{id}/edit

     * Update the specified resource in storage.
     * PUT /categories/{id}

     * Remove the specified resource from storage.
     * DELETE /categories/{id}

     */
