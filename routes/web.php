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
    Route::get('/{id}/floor/{floor}','BuildingsController@floorSort')->name('floor_sort');
    Route::get('/{id}/layout_type/{layout}','BuildingsController@layoutTypeSort')->name('layout_type_sort');
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
    Route::get('/rent/{id}','SoldRentRoomController@create')->name('sold_rent_create');//賃貸成約新規
    Route::post('/rent/store/{id}','SoldRentRoomController@store')->name('sold_rent_store');
});

Route::prefix('room')->group(function(){
    Route::get('/{id}','RoomsController@show')->name('room_show');
    Route::get('/{id}/edit','RoomsController@edit')->name('room_edit');
    Route::put('/{id}/update','RoomsController@update')->name('room_update');
    Route::get('/show/{id}/sales','RoomsController@sales')->name('room_sales');//売買切り替え
    Route::get('/show/{id}/rent','RoomsController@rent')->name('room_rent');//賃貸切り替え
    Route::get('/show/{id}/rent/edit','RoomsController@rentEdit')->name('rent_edit');//賃貸編集
    Route::put('/show/{roomId}/rent/update/{stockId?}/{soldId?}','RoomsController@rentUpdate')->name('rent_update');//賃貸編集
    Route::get('/show/{id}/sales/edit','RoomsController@salesEdit')->name('sales_edit');//売買編集
    Route::put('/show/{roomId}/sales/update/{stockId?}/{soldId?}','RoomsController@salesUpdate')->name('sales_update');//売買編集
});

Route::prefix('register')->group(function(){
    Route::post('/upload/{id}','CopyOfRegisterController@upload')->name('pdf_upload');
    Route::get('/show/{id}','CopyOfRegisterController@show')->name('pdf_show');
});
Route::post('import','CSVController@import')->name('import');
