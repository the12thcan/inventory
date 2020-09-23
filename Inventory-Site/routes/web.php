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

use App\Http\Controllers\ItemsController;


//Route::get('/admin_panel', 'PagesController@adminPanel')->middleware('auth');

Route::group(['middleware' => ['App\Http\Middleware\AdminMiddleware']], function () {
    //admin routes
    Route::get('/admin_panel', 'PagesController@adminPanel')->middleware('auth');
});

Route::group(['middleware' => ['App\Http\Middleware\AddModifyMiddleware']], function () {
    Route::get('/new_items', 'PagesController@newItems')->middleware('auth');
    Route::get('/modify_items', 'PagesController@modifyItems')->middleware('auth');
    Route::get('/add_inventory', 'PagesController@addInv')->middleware('auth');
    Route::get('/remove_inventory', 'PagesController@remInv')->middleware('auth');
    Route::get('/history', 'HistoryController@index')->middleware('auth');
});

Route::group(['middleware' => ['App\Http\Middleware\DashboardMiddleware']], function () {
    //admin routes
    Route::get('/', 'DashboardController@index')->middleware('auth');
    Route::get('/dashboard', 'DashboardController@index')->middleware('auth');

});

Auth::routes();


// Route for interacting with items in the database
Route::resource('items', 'ItemsController')->middleware('auth');

// Route for interacting with order transactions
Route::resource('transactions', 'TransactionsController')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('admin', 'AdminController')->middleware('auth');

Route::resource('member_position', 'MemberPositionsController')->middleware('auth');

Route::resource('users', 'UsersController')->middleware('auth');

