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


Route::get('/', function(){
    Queue::push(function($job)
    {
        Log::info('Queud!');
        $job->delete();
    });
});

/**
 * Transactions List
 */
Route::get('transactions', ['uses' => 'TransactionsController@index', 'as' => 'transactions.index']);


/**
 * Statement Import Handler
 */
Route::post('import', ['uses' => 'ImportController@import', 'as' => 'import']);


/**
 * Package Export Handler
 */
Route::post('export', ['uses' => 'ExportController@export', 'as' => 'export']);


/**
 * Records
 * The routes to manage income and expenses
 */
Route::get('income', ['uses' => 'RecordsController@showIncome', 'as' => 'income.index']);
Route::get('expenses', ['uses' => 'RecordsController@showExpenses', 'as' => 'expense.index']);

Route::post('records', ['uses' => 'RecordsController@store', 'as' => 'records.create']);
Route::post('records/update/{record}', ['uses' => 'RecordsController@update', 'as' => 'records.update']);
Route::post('records/{id}/attachment', ['uses' => 'RecordsController@attach', 'as' => 'records.attach']);


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


/**
 * Uploaded Images
 */
Route::get('img/{filename}', function($filename){

    $file = Config::get('image.upload_dir') . $filename;

    if (empty($filename) || ! file_exists($file)) {
        App::abort(404, 'Image Not Found');
    }

    return Image::make($file)->response();
});