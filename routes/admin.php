<?php

use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\CmsController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\BankController;
use App\Http\Controllers\admin\MoneyTransferController;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace'=>'admin', 'prefix'=>'adminpanel', 'as'=>'admin.'], function() {

    // Before Authentication
    Route::controller(AuthController::class)->group(function() {
        Route::name('auth.')->group(function () {
            Route::get('/', 'login')->name('login');
            Route::patch('/', 'login')->name('login');
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::patch('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::get('/reset-password/{token}', 'resetPassword')->name('reset-password');
            Route::patch('/reset-password/{token}', 'resetPassword')->name('reset-password');
        });
    });
    Route::post('/ckeditor-upload', [CmsController::class, 'upload'])->name('ckeditor-upload');

    Route::group(['middleware' => 'backend'], function () {
        Route::controller(AccountController::class)->group(function() {
            Route::name('account.')->group(function () {
                Route::get('/dashboard', 'dashboard')->name('dashboard');
                Route::get('/profile', 'profile')->name('profile');
                Route::patch('/profile', 'profile');
                Route::get('/change-password', 'changePassword')->name('change-password');
                Route::patch('/change-password', 'changePassword');
                Route::get('/settings', 'settings')->name('settings');
                Route::patch('/settings', 'settings');
            });
        });

        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::group(['middleware' => 'admin'], function () {
            Route::controller(CmsController::class)->group(function() {
                Route::prefix('cms')->name('cms.')->group(function () {
                    Route::get('/list', 'list')->name('list');
                    Route::post('/ajax-list-request', 'ajaxListRequest')->name('ajax-list-request');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/create', 'create');
                    Route::get('/edit/{cms}', 'edit')->name('edit');
                    Route::put('/edit/{cms}', 'edit');
                    Route::get('/status/{cms}', 'status')->name('change-status');
                    Route::delete('/delete/{cms}', 'delete')->name('delete');

                });
            });
            Route::controller(CountryController::class)->group(function () {
                Route::prefix('country')->name('country.')->group(function () {
                    Route::get('/list', 'list')->name('list');
                    Route::post('/ajax-list-request', 'ajaxListRequest')->name('ajax-list-request');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/create', 'create');
                    Route::get('/edit/{country}', 'edit')->name('edit');
                    Route::put('/edit/{country}', 'edit');
                    Route::get('/status/{country}', 'status')->name('change-status');
                    Route::delete('/delete/{country}', 'delete')->name('delete');
                });
            });

            Route::controller(CurrencyController::class)->group(function () {
                Route::prefix('currency')->name('currency.')->group(function () {
                    Route::get('/list', 'list')->name('list');
                    Route::post('/ajax-list-request', 'ajaxListRequest')->name('ajax-list-request');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/create', 'create');
                    Route::get('/edit/{currency}', 'edit')->name('edit');
                    Route::put('/edit/{currency}', 'edit');
                    Route::get('/status/{currency}', 'status')->name('change-status');
                    Route::delete('/delete/{currency}', 'delete')->name('delete');

                    Route::prefix('transfer-fees')->name('transfer-fees.')->group(function () {
                        Route::get('/list/{currency}', 'transferFeesList')->name('transfer-fees-list');
                        Route::post('/ajax-list-request', 'ajaxTransferFeesListRequest')->name('ajax-list-request');
                        Route::get('/create/{currency}', 'transferFeesCreate')->name('transfer-fees-create');
                        Route::post('/create/{currency}', 'transferFeesCreate');
                        Route::get('/edit/{transferFee}', 'transferFeesEdit')->name('transfer-fees-edit');
                        Route::put('/edit/{transferFee}', 'transferFeesEdit');
                        Route::get('/status/{transferFee}', 'transferFeesStatus')->name('transfer-fees-change-status');
                        Route::delete('/delete/{transferFee}', 'transferFeesDelete')->name('transfer-fees-delete');
                    });
                });
            });

            Route::controller(BankController::class)->group(function () {
                Route::prefix('bank')->name('bank.')->group(function () {
                    Route::get('/list', 'list')->name('list');
                    Route::post('/ajax-list-request', 'ajaxListRequest')->name('ajax-list-request');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/create', 'create');
                    Route::get('/edit/{bank}', 'edit')->name('edit');
                    Route::put('/edit/{bank}', 'edit');
                    Route::get('/status/{bank}', 'status')->name('change-status');
                    Route::delete('/delete/{bank}', 'delete')->name('delete');
                });
            });

            Route::controller(MoneyTransferController::class)->group(function () {
                Route::prefix('money-transfer')->name('money-transfer.')->group(function () {
                    Route::get('/list', 'list')->name('list');
                    Route::post('/ajax-list-request', 'ajaxListRequest')->name('ajax-list-request');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/create', 'create');
                    Route::get('/edit/{bank}', 'edit')->name('edit');
                    Route::put('/edit/{bank}', 'edit');
                    Route::get('/status/{bank}', 'status')->name('change-status');
                    Route::delete('/delete/{bank}', 'delete')->name('delete');
                });
            });

            Route::controller(UserController::class)->group(function () {
                Route::prefix('user')->name('user.')->group(function () {
                    Route::get('/list', 'list')->name('list');
                    Route::post('/ajax-list-request', 'ajaxListRequest')->name('ajax-list-request');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/create', 'create');
                    Route::get('/edit/{user}', 'edit')->name('edit');
                    Route::put('/edit/{user}', 'edit');
                    Route::get('/status/{user}', 'status')->name('change-status');
                    Route::delete('/delete/{user}', 'delete')->name('delete');
                });
            });
        });
    });

});


