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
Route::post('/staff', 'StaffController@store')->name('staff/store');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/documents', 'DocumentsController@index')->name('documents');

    // Payments
    Route::get('/payments', 'PaymentsController@payments')->name('payments');
    Route::post('/payments/reports', 'PaymentsController@generateReport')->name('payments/reports');
    Route::get('/payments/pending', 'PaymentsController@pending')->name('pending-payments');
    Route::get('/payments/load-json', 'PaymentsController@json')->name('load-json');
    Route::post('/payments/load-json', 'PaymentsController@storeJson')->name('store-json');
    Route::get('/payments/pending-payments', 'PaymentsController@fetchPendingPayments')->name('fetch-pending-payments');
    Route::get('/payments/fetch-payments', 'PaymentsController@fetchPayments')->name('fetch-payments');

    // Recharges
    Route::get('/recharges', 'RechargesController@index')->name('recharges');
    Route::get('/recharges/create', 'RechargesController@create')->name('recharges/create');
    Route::get('/recharges/fetch', 'RechargesController@fetch')->name('recharges/fetch');
    Route::get('/recharges/details/{id}', 'RechargesController@details')->name('recharges/details');
    Route::post('/recharges/update/{id}', 'RechargesController@update')->name('recharges/update');
    Route::post('/recharges/store', 'RechargesController@store')->name('recharges/store');
    
    // Claims
    Route::get('/claims', 'ClaimsController@index')->name('claims');
    Route::post('/claims/store', 'ClaimsController@store')->name('claims/store');
    Route::get('/claims/check/{id}', 'ClaimsController@check')->name('claims/check');
    Route::get('/claims/details/{id}', 'ClaimsController@details')->name('claims/details');
    Route::get('/claims/fetch', 'ClaimsController@fetch')->name('claims/fetch');
    
    // Payment by airplane
    Route::get('/payments/filter/plane', 'PaymentsController@filterByPlane')->name('payments/filter/plane');
    Route::post('/payments/filter/plane/pending', 'PaymentsController@pendingPaymentsByPlane')->name('payments/filter/plane/pending');
    Route::get('/payments/{paymentId}/pay/create', 'PaymentsController@createPayByAirplane')->name('payments/pay/create');
    Route::post('/payments/{paymentId}/pay/store', 'PaymentsController@payCreated')->name('payments/pay/store');     
    
    Route::get('/payments/manual', 'PaymentsController@manual')->name('manual-payments');
    Route::post('/payments/manual', 'PaymentsController@storeManual')->name('manual-payments');
    Route::get('/clients/fetch/plane/{id}', 'ClientsController@fetchByPlane')->name('fetch-clients-by-plane');
    
    // Payment documents
    Route::get('/payments/{id}/documents/', 'PaymentDocumentsController@index')->name('payment-documents');
    Route::post('/payments/{id}/documents/', 'PaymentDocumentsController@store')->name('store-payment-documents');
    
    // Dosa
    Route::get('/payments/{id}/dosa/', 'DosasController@paymentDosas')->name('payment-dosa');
    
    // Payment recipe
    Route::get('/payments/{id}/receipt', 'PaymentsController@receipt')->name('payment-receipt');
    
    // Profile
    Route::get('/users/profile', 'UsersController@profile')->name('users/profile');
    Route::get('/users/edit-profile', 'UsersController@editProfile')->name('users/edit-profile');
    Route::post('/users/edit-profile', 'UsersController@updateProfile')->name('users/update-profile');
    Route::post('/users/change-password', 'UsersController@changePassword')->name('users/change-password');
    
    // Manager exclusive routes
    Route::group(['middleware' => ['permission:create-users']], function () {
        // Users
        Route::get('/users', 'UsersController@index')->name('users');
        Route::get('/users/create', 'UsersController@create')->name('users/create');
        Route::post('/users/create', 'UsersController@store')->name('users/store');
        Route::get('/users/fetch', 'UsersController@fetch')->name('users/fetch');
    });
    
    // Client exclusive routes
    Route::group(['middleware' => ['role:CLIENT']], function () {
        // Dosas
        Route::get('/dosas/plane', 'DosasController@filterByPlane')->name('dosas/plane');
        Route::post('/dosas/plane', 'DosasController@pendingByPlane')->name('dosas/plane');
        Route::get('/dosas/plane/{tailNumber}', 'DosasController@clientDosas')->name('dosas/plane/tail-number');
        Route::get('/dosas', 'DosasController@filterByPlane')->name('dosas');
        Route::get('/dosas/{id}', 'DosasController@detail')->name('dosa-detail');
        Route::post('/dosas', 'DosasController@pay')->name('pay-dosa');
    });
    
});

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});


