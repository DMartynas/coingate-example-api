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

Route::get('/', 'PagesController@index');
Route::get('/shop', 'PagesController@shop');
Route::resource('products', 'ProductsController');
Route::get('/products/order/{id}', 'ProductsController@order');
Route::post('/products/order/WL{id}', 'ProductsController@orderWL');
Route::get('/success', 'PagesController@success');
Route::get('/failed', 'PagesController@failed');
Route::post('/coingate_callback', 'ProductsController@callback');
Route::post('/check_status', 'ProductsController@getStatus');
Route::get('/search', 'PagesController@search');
Route::put('/dashboard', 'OrdersController@update')->name('updateOrder');
Route::get('/list/{nr}', ['as' => 'nr', 'uses'=>'PagesController@listO']);
Route::delete('/products/{id}/delete', 'ProductsController@destroy')->name('prod.destroy');
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
