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

Route::get('/splitJson', function () {

   // $operator = "AND";

//    if( true {$operator} true ){
//        dd(true);
//    }

    $split = [
        [
            'description' => 'Split Description One',
            'category_id' => 1,
            'stream_id'   => 1,
            'percentage'  => 35
        ],
        [
            'description' => 'Split Description Two',
            'category_id' => 2,
            'stream_id'   => 1,
            'percentage'  => 35
        ],
        [
            'description' => 'Split Description three',
            'category_id' => 53,
            'stream_id'   => 3,
            'percentage'  => 30
        ]
    ];

    return Response::json($split);
    // return View::make('login');
});

/**
 * Transactions List
 */
Route::get('transactions', ['uses' => 'TransactionsController@index', 'as' => 'transactions.index']);

/**
 * Statement Import Handler
 */
Route::post('statements/import', ['uses' => 'StatementsController@import', 'as' => 'statements.import']);
// Route::get('statements/import', 'StatementsController@erm');

/**
 * Records Resource
 */
// Route::resource('records', 'RecordController');
// Route::resource('/settings/streams', 'StreamsController');

/**
 * Records
 * The routes to manage income and expenses
 */
Route::get('income', ['uses' => 'RecordsController@showIncome', 'as' => 'income.index']);
Route::get('expenses', ['uses' => 'RecordsController@showExpenses', 'as' => 'expenses.index']);

Route::post('records', ['uses' => 'RecordsController@store', 'as' => 'records.create']);
//Route::post('settings/categories/edit/{category}', ['uses' => 'CategoriesController@update', 'as' => 'categories.update']);
//Route::post('settings/categories/delete/{category}', ['uses' => 'CategoriesController@delete', 'as' => 'categories.delete']);

/**
 * Categories
 *
 * The routes to create a Category
 */
Route::get('settings/categories', ['uses' => 'CategoriesController@index', 'as' => 'categories.index']);
Route::post('settings/categories', ['uses' => 'CategoriesController@store', 'as' => 'categories.create']);
Route::post('settings/categories/edit/{category}', ['uses' => 'CategoriesController@update', 'as' => 'categories.update']);
Route::post('settings/categories/delete/{category}', ['uses' => 'CategoriesController@delete', 'as' => 'categories.delete']);

/**
 * Streams
 *
 * The routes to create a Stream
 */
Route::get('settings/streams', ['uses' => 'StreamsController@index', 'as' => 'streams.index']);
Route::post('settings/streams', ['uses' => 'StreamsController@store', 'as' => 'streams.create']);
Route::post('settings/streams/edit/{category}', ['uses' => 'StreamsController@update', 'as' => 'streams.update']);
Route::post('settings/streams/delete/{category}', ['uses' => 'StreamsController@delete', 'as' => 'streams.delete']);