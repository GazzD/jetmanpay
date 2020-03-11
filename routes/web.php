<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
    Route::get('/payments/pending', 'PaymentsController@index')->name('pending-payments');
    Route::get('/payments/load-json', 'PaymentsController@json')->name('load-json');
    Route::post('/payments/load-json', 'PaymentsController@storeJson')->name('store-json');
    Route::get('/payments/pending-payments', 'PaymentsController@pendingPayments')->name('fetch-pending-payments');

    Route::get('/payments/manual', 'PaymentsController@manual')->name('manual-payments');
    Route::get('/clients/fetch/plane/{id}', 'ClientsController@fetchByPlane')->name('fetch-clients-by-plane');
    Route::post('/payments/manual', 'PaymentsController@storeManual')->name('manual-payments');

});

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});


