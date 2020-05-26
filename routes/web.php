<?php

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

Route::get('/', 'BuildingsController@index');

Route::prefix('buildings')->group(function(){
    Route::get('/show/{id}','BuildingsController@show')->name('buildings_show');
});

Route::prefix('stocks')->group(function(){
    Route::get('/sales/{id}','StockSalesRoomController@create')->name('stock_sales_create');//売買在庫新規
    Route::post('/sales/store/{id}','StockSalesRoomController@store')->name('stock_sales_store');
    Route::get('/rent/{id}','StockRentRoomController@create')->name('stock_rent_create');//賃貸在庫新規
    Route::post('/rent/store/{id}','StockRentRoomController@store')->name('stock_rent_store');
});
Route::prefix('sold')->group(function(){
    Route::get('/sales/{id}','SoldSalesRoomController@create')->name('sold_sales_create');//売買成約新規
    Route::post('/sales/store/{id}','SoldSalesRoomController@store')->name('sold_sales_store');
    Route::get('/rent/{id}','SoldRentRoomController@create')->name('sold_rent_create');//売買成約新規
    Route::post('/rent/store/{id}','SoldRentRoomController@store')->name('sold_rent_store');
});

Route::prefix('room')->group(function(){
    Route::get('room/{id}','RoomsController@show')->name('room_show');
    Route::get('/show/{id}/sales','RoomsController@sales')->name('room_sales');//売買切り替え
});
Route::post('import','CSVController@import')->name('import');
