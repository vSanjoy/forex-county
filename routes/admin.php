<?php

use App\Http\Controllers\admin\CountryController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\CmsController;

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
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::put('/edit/{id}', 'edit');
                    Route::get('/status/{id}', 'status')->name('change-status');

                });
            });

            Route::controller(CountryController::class)->group(function () {
                Route::prefix('country')->name('country.')->group(function () {
                    Route::get('/list', 'list')->name('list');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/ajax-list-request', 'ajaxListRequest')->name('ajax-list-request');
                });
            });
        });
    });

});


