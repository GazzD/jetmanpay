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
// Public routes
Auth::routes();
Route::post('/staff', 'StaffController@store')->name('staff/store');

// Private routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    
    // Payments
    Route::post('/payments/reports', 'PaymentsController@generateReport')->name('payments/reports');
    Route::get('/payments/pending', 'PaymentsController@pending')->name('pending-payments');
    Route::get('/payments/pending-payments', 'PaymentsController@fetchPendingPayments')->name('fetch-pending-payments');
    Route::get('/payments/fetch-payments', 'PaymentsController@fetchPayments')->name('fetch-payments');
    
    // Recharges 
    Route::group(['middleware' => ['permission:admin-recharges']], function () {
        Route::get('/recharges', 'RechargesController@index')->name('recharges');
        Route::get('/recharges/create', 'RechargesController@create')->name('recharges/create');
        Route::get('/recharges/fetch', 'RechargesController@fetch')->name('recharges/fetch');
        Route::get('/recharges/details/{id}', 'RechargesController@details')->name('recharges/details');
        Route::post('/recharges/update/{id}', 'RechargesController@update')->name('recharges/update');
        Route::post('/recharges/store', 'RechargesController@store')->name('recharges/store');
    });
    
    // Claims
    Route::group(['middleware' => ['permission:admin-claims']], function () {
        Route::get('/claims', 'ClaimsController@index')->name('claims');
        Route::post('/claims/store', 'ClaimsController@store')->name('claims/store');
        Route::get('/claims/check/{id}', 'ClaimsController@check')->name('claims/check');
        Route::get('/claims/details/{id}', 'ClaimsController@details')->name('claims/details');
        Route::get('/claims/fetch', 'ClaimsController@fetch')->name('claims/fetch');
    });
    
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
    
    // Manager exclusive routes
    Route::group(['middleware' => ['permission:admin-users']], function () {
        // Users
        Route::get('/users', 'UsersController@index')->name('users');
        Route::get('/users/create', 'UsersController@create')->name('users/create');
        Route::post('/users/create', 'UsersController@store')->name('users/store');
        Route::get('/users/fetch', 'UsersController@fetch')->name('users/fetch');
    });
    
    // Client and treasurers exclusive routes
    Route::group(['middleware' => ['role:CLIENT|TREASURER1|TREASURER2']], function () {
        // Dosas
        Route::get('/dosas', 'DosasController@filterByPlane')->name('dosas');
        Route::post('/dosas', 'DosasController@pay')->name('pay-dosa');
        Route::get('/dosas/plane', 'DosasController@filterByPlane')->name('dosas/plane');
        Route::post('/dosas/plane', 'DosasController@pendingByPlane')->name('dosas/plane');
        Route::post('/payments/dosa', 'PaymentsController@storeDosa')->name('payments/dosa');
        Route::get('/dosas/plane/{tailNumber}', 'DosasController@clientDosas')->name('dosas/plane/tail-number');
        Route::get('/dosas/{id}', 'DosasController@detail')->name('dosa-detail');

        //Payments
        Route::get('/payments', 'PaymentsController@payments')->name('payments');
        Route::get('/payments/{id}', 'PaymentsController@details')->name('payments/details');
        Route::post('/payments/{id}', 'PaymentsController@update')->name('payments/update');
    });

    // Planes
    Route::group(['middleware' => ['permission:admin-planes']], function () {
        Route::get('/planes', 'PlanesController@index')->name('planes');
        Route::get('/planes/fetch', 'PlanesController@fetchPlanes')->name('planes/fetch');
    });
    
    // Settings
    Route::group(['middleware' => ['permission:admin-settings']], function () {
        Route::get('/users/profile', 'UsersController@profile')->name('users/profile');
        Route::get('/users/edit-profile', 'UsersController@editProfile')->name('users/edit-profile');
        Route::post('/users/edit-profile', 'UsersController@updateProfile')->name('users/update-profile');
        Route::post('/users/change-password', 'UsersController@changePassword')->name('users/change-password');
    });
    
    // Documents
    Route::group(['middleware' => ['permission:admin-documents']], function () {
        Route::get('/documents', 'DocumentsController@index')->name('documents');
    });
    
});

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});


