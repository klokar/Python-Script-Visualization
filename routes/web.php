<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->to('register');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('processor','ProcessorController',
        ['only' => ['index', 'create']]
    );

    Route::resource('dataset','DatasetController',
        ['only' => ['index', 'create']]
    );

    Route::get('execution/report', 'ExecutionController@report');
    Route::get('execution/{id}/output', 'ExecutionController@output');
    Route::post('execution/{id}/report', 'ExecutionController@report');
    Route::resource('execution','ExecutionController',
        ['only' => ['index', 'create', 'show']]
    );
});
