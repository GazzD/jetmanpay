<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/documents', 'DocumentsController@index')->name('documents');

    //Payments
    Route::get('/payments/pending', 'PaymentsController@pending')->name('pending-payments');
    Route::get('/payments/payments', 'PaymentsController@payments')->name('payments');
    Route::get('/payments/load-json', 'PaymentsController@json')->name('load-json');
    Route::post('/payments/load-json', 'PaymentsController@storeJson')->name('store-json');
    Route::get('/payments/pending-payments', 'PaymentsController@fetchPendingPayments')->name('fetch-pending-payments');
    Route::get('/payments/fetch-payments', 'PaymentsController@fetchPayments')->name('fetch-payments');
    
    Route::get('/payments/filter/plane', 'PaymentsController@filterByPlane')->name('payments/filter/plane');
    Route::post('/payments/filter/plane/pending', 'PaymentsController@pendingPaymentsByPlane')->name('payments/filter/plane/pending');
    Route::post('/payments/{paymentId}/pay', 'PaymentsController@pay')->name('payments/pay');     
    
    Route::get('/payments/manual', 'PaymentsController@manual')->name('manual-payments');
    Route::get('/clients/fetch/plane/{id}', 'ClientsController@fetchByPlane')->name('fetch-clients-by-plane');
    Route::post('/payments/manual', 'PaymentsController@storeManual')->name('manual-payments');
    
    
    //Users
    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/users/create', 'UsersController@create')->name('users/create');
    Route::post('/users/create', 'UsersController@store')->name('users/store');
    Route::get('/users/fetch', 'UsersController@fetch')->name('users/fetch');


});

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});


