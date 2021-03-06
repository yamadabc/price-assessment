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
    Route::get('/show/{id}','BuildingsController@show')->name('buildings_show');//物件ごとのtop page(table表示)
    Route::get('/stucking/{id}','BuildingsController@stucking')->name('buildings_stucking');//物件ごとのtop page(stucking表示)
    Route::get('/{id}/floor/{floor}','BuildingsController@floorSort')->name('floor_sort');
    Route::get('/{id}/layout_type/{layoutType}','BuildingsController@layoutTypeSort')->name('layout_type_sort');
});

Route::prefix('stocks')->group(function(){
    Route::get('/sales/{id}','StockSalesRoomController@create')->name('stock_sales_create');//売買在庫新規
    Route::post('/sales/{id}','StockSalesRoomController@store')->name('stock_sales_store');
    Route::get('/rent/{id}','StockRentRoomController@create')->name('stock_rent_create');//賃貸在庫新規
    Route::post('/rent/{id}','StockRentRoomController@store')->name('stock_rent_store');
});
Route::prefix('sold')->group(function(){
    Route::get('/sales/{id}','SoldSalesRoomController@create')->name('sold_sales_create');//売買成約新規
    Route::post('/sales/{id}','SoldSalesRoomController@store')->name('sold_sales_store');
    Route::get('/rent/{id}','SoldRentRoomController@create')->name('sold_rent_create');//賃貸成約新規
    Route::post('/rent/{id}','SoldRentRoomController@store')->name('sold_rent_store');
});

Route::prefix('room')->group(function(){
    Route::get('/{id}','RoomsController@show')->name('room_show');
    Route::get('/{id}/edit','RoomsController@edit')->name('room_edit');
    Route::put('/{id}','RoomsController@update')->name('room_update');
    Route::get('/create/{id}','RoomsController@create')->name('room_create');
    Route::post('/create/{id}','RoomsController@store')->name('room_store');
});
Route::prefix('sales')->group(function(){
    Route::post('/{stockSalesRoomId?}/{soldSalesRoomId?}','SalesController@destroy')->name('sales_delete');
    Route::get('/{id}/sales','SalesController@salesAll')->name('building_sales');//売買切り替え(全体)
    Route::get('/show/{id}','SalesController@sales')->name('room_sales');//売買切り替え(1部屋)
    Route::get('/edit/{id}','SalesController@Edit')->name('sales_edit');//売買編集
    Route::put('/update/{roomId}/{stockId?}/{soldId?}','SalesController@Update')->name('sales_update');//売買編集
    Route::get('/{id}/floor/{floor}','SalesController@floorSort')->name('floor_sort.sales');//売買階数絞り
    Route::get('/{id}/layout_type/{layoutType}','SalesController@layoutTypeSort')->name('layout_type.sales');//間取タイプ別絞り
});
Route::prefix('rent')->group(function(){
    Route::get('/{id}/stocks','RentController@stocksAll')->name('building_stocks');//賃貸切り替え(全体)
    Route::post('/{stockRentRoomId?}/{soldRentRoomId?}','RentController@destroy')->name('rent_delete');
    Route::get('/show/{id}','RentController@rent')->name('room_rent');//賃貸切り替え(1部屋)
    Route::get('/edit/{id}','RentController@Edit')->name('rent_edit');//賃貸編集
    Route::put('/updata/{roomId}/{stockId?}/{soldId?}','RentController@Update')->name('rent_update');//賃貸編集
    Route::get('/{id}/floor/{floor}','RentController@floorSort')->name('floor_sort.rent');//賃貸階数絞り
    Route::get('/{id}/layout_type/{layoutType}','RentController@layoutTypeSort')->name('layout_type.rent');//間取タイプ別絞り
});
//登記簿謄本
Route::prefix('register')->group(function(){
    Route::post('/upload/{id}','CopyOfRegisterController@upload')->name('pdf_upload');
    Route::get('/show/{id}','CopyOfRegisterController@show')->name('pdf_show');
});
//csvアップロード
Route::prefix('import')->group(function(){
    Route::post('/rooms','CSVController@importRoom')->name('import.room');
    Route::post('/buildings','CSVController@importBuilding')->name('import.building');
    Route::post('/rooms/update','CSVController@importRoomUpdate')->name('import.roomsUpdate');
    Route::post('/buildings/update','CSVController@importBuildingUpdate')->name('import.buildingsUpdate');
});
