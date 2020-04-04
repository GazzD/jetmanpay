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

    // Payments
    Route::get('/payments', 'PaymentsController@payments')->name('payments');
    Route::post('/payments/reports', 'PaymentsController@generateReport')->name('payments/reports');
    Route::get('/payments/pending', 'PaymentsController@pending')->name('pending-payments');
    Route::get('/payments/load-json', 'PaymentsController@json')->name('load-json');
    Route::post('/payments/load-json', 'PaymentsController@storeJson')->name('store-json');
    Route::get('/payments/pending-payments', 'PaymentsController@fetchPendingPayments')->name('fetch-pending-payments');
    Route::get('/payments/fetch-payments', 'PaymentsController@fetchPayments')->name('fetch-payments');
    
    // Payment by airplane
    Route::get('/payments/filter/plane', 'PaymentsController@filterByPlane')->name('payments/filter/plane');
    Route::post('/payments/filter/plane/pending', 'PaymentsController@pendingPaymentsByPlane')->name('payments/filter/plane/pending');
    Route::get('/payments/{paymentId}/pay/create', 'PaymentsController@createPayByAirplane')->name('payments/pay/create');
    Route::post('/payments/{paymentId}/pay/store', 'PaymentsController@payCreated')->name('payments/pay/store');     
    
    Route::get('/payments/manual', 'PaymentsController@manual')->name('manual-payments');
    Route::get('/clients/fetch/plane/{id}', 'ClientsController@fetchByPlane')->name('fetch-clients-by-plane');
    Route::post('/payments/manual', 'PaymentsController@storeManual')->name('manual-payments');
    
    // Payment documents
    Route::get('/payments/{id}/documents/', 'PaymentDocumentsController@index')->name('payment-documents');
    Route::post('/payments/{id}/documents/', 'PaymentDocumentsController@store')->name('store-payment-documents');
    
    // Payment DOSA
    Route::get('/payments/{id}/dosa/', 'PaymentDosasController@index')->name('payment-dosa');
    
    // Payment recipe
    Route::get('/payments/{id}/receipt', 'PaymentsController@receipt')->name('payment-receipt');
    
    // Profile
    Route::get('/users/profile', 'UsersController@profile')->name('users/profile');
    Route::get('/users/edit-profile', 'UsersController@editProfile')->name('users/edit-profile');
    Route::post('/users/edit-profile', 'UsersController@updateProfile')->name('users/update-profile');
    Route::post('/users/change-password', 'UsersController@changePassword')->name('users/change-password');
    
    // Manager exclusive routes
    Route::group(['middleware' => ['role:MANAGER']], function () {
        // Users
        Route::get('/users', 'UsersController@index')->name('users');
        Route::get('/users/create', 'UsersController@create')->name('users/create');
        Route::post('/users/create', 'UsersController@store')->name('users/store');
        Route::get('/users/fetch', 'UsersController@fetch')->name('users/fetch');
    });


});

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});


