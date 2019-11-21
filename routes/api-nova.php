<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Nova Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/{any}/{resource}', 'ResourceStoreController@handle');
Route::put('/{any}/{resource}/{resourceId}', 'ResourceUpdateController@handle');
