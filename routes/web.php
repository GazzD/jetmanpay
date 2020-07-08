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

// Test routes
Route::get('/test1', 'TestController@test1')->name('test1');
Route::get('/test2', 'TestController@test2')->name('test2');

// Private routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    
    // Pending Payments
    Route::group(['middleware' => ['permission:admin-pending-payments']], function () {
        Route::get('/payments/pending', 'PaymentsController@indexPending')->name('payments/pending');
        Route::get('/payments/completed', 'PaymentsController@indexCompleted')->name('payments/completed');
        Route::get('/payments/fetch/pending', 'PaymentsController@fetchPending')->name('payments/fetch/pending');
        Route::get('/payments/fetch/completed', 'PaymentsController@fetchCompleted')->name('payments/fetch/completed');
    });
    // Generate Payment reports
    Route::group(['middleware' => ['permission:generate-payments-reports']], function () {
        Route::post('/payments/reports', 'PaymentsController@generateReport')->name('payments/reports');
    });
    
    Route::get('/payments/manual', 'PaymentsController@manual')->name('manual-payments');
    Route::post('/payments/manual', 'PaymentsController@storeManual')->name('manual-payments');
    Route::get('/clients/fetch/plane/{id}', 'ClientsController@fetchByPlane')->name('fetch-clients-by-plane');
    
    // Payments
    Route::group(['middleware' => ['permission:admin-payments']], function () {
        Route::get('/payments', 'PaymentsController@index')->name('payments');
        Route::get('/payments/fetch/all', 'PaymentsController@fetchAll')->name('payments/fetch/all');
        Route::get('/payments/{id}', 'PaymentsController@details')->name('payments/details');
        Route::post('/payments/{id}', 'PaymentsController@update')->name('payments/update');
    });

    // Edit clients
    Route::group(['middleware' => ['permission:update-client']], function () {
        Route::get('/clients/edit', 'ClientsController@edit')->name('clients/edit');
        Route::post('/clients/update', 'ClientsController@update')->name('clients/update');
    });
    
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
    Route::group(['middleware' => ['permission:create-claims']], function () {
        Route::post('/claims/store', 'ClaimsController@store')->name('claims/store');
    });
    Route::group(['middleware' => ['permission:admin-claims']], function () {
        Route::get('/claims', 'ClaimsController@index')->name('claims');
        Route::post('/claims/check', 'ClaimsController@check')->name('claims/check');
        Route::get('/claims/details/{id}', 'ClaimsController@details')->name('claims/details');
        Route::get('/claims/fetch', 'ClaimsController@fetch')->name('claims/fetch');
    });
    
    // Payment by airplane
    Route::get('/payments/filter/plane', 'PaymentsController@filterByPlane')->name('payments/filter/plane');
    Route::post('/payments/filter/plane/pending', 'PaymentsController@pendingPaymentsByPlane')->name('payments/filter/plane/pending');
    Route::get('/payments/{paymentId}/pay/create', 'PaymentsController@createPayByAirplane')->name('payments/pay/create');
    Route::post('/payments/{paymentId}/pay/store', 'PaymentsController@payCreated')->name('payments/pay/store');     
    
    // Payment by DOSA
    Route::post('/payments/dosa/create', 'PaymentsController@createByDosa')->name('payments/dosa/create');
    Route::post('/payments/dosa/store', 'PaymentsController@storeByDosa')->name('payments/dosa/store');
    // Route::post('/payments/pending', 'PaymentsController@indexPending')->name('payments/dosa/pending');
    
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
        Route::get('/dosas/approved', 'DosasController@filterByApproved')->name('dosas/approved');
        Route::get('/dosas/fetch/approved', 'DosasController@fetchApproved')->name('dosas/fetch/approved');
        Route::get('/dosas', 'DosasController@filterByPlane')->name('dosas');
        Route::post('/dosas', 'DosasController@pay')->name('pay-dosa');
        Route::get('/dosas/plane', 'DosasController@filterByPlane')->name('dosas/plane');
        Route::post('/dosas/plane', 'DosasController@pendingByPlane')->name('dosas/plane');
        Route::get('/dosas/plane/{tailNumber}', 'DosasController@clientDosas')->name('dosas/plane/tail-number');
        Route::get('/dosas/{id}', 'DosasController@detail')->name('dosa-detail');
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

    Route::group(['middleware' => ['permission:admin-system-information']], function () {
        //System
        Route::get('/system', 'SystemController@index')->name('system');
        Route::get('/system/fetch', 'SystemController@fetch')->name('system/fetch');
        
        //Transfers
        Route::get('/transfers', 'TransfersController@index')->name('transfers');
        Route::get('/transfers/fetch', 'TransfersController@fetch')->name('transfers/fetch');
        Route::get('/transfers/create', 'TransfersController@create')->name('transfers/create');
        Route::post('/transfers/store', 'TransfersController@store')->name('transfers/store');
        Route::get('/transfers/{id}', 'TransfersController@details')->name('transfers/details');
        Route::post('/transfers/approve', 'TransfersController@approve')->name('transfers/approve');
    });
    
});

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});


