<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Controllers
use App\Http\Controllers\api\TemporaryUserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('api')->namespace('api')->prefix("v1")->group(function () {
//     Route::get('/', 'HomeController@index')->name('api_index');
//     Route::get('/generate-token', 'HomeController@generateToken')->name('api_generate_token');
//     Route::get('/page/{id}', 'HomeController@pageContent')->name('api_get_page_content');
//     Route::post('/signout', 'UserController@signOut')->name('api_signout');
    
    
//     Route::middleware('api.token')->group(function () {
//         // Auth
//         Route::post('/sign-up', 'UserController@signUp')->name('api_sign_up');
//         Route::post('/sign-in', 'UserController@signIn')->name('api_sign_in');
        
//     });

// });

Route::group(['middleware'=>'api', 'namespace'=>'api', 'prefix'=>'v1', 'as'=>'api.'], function() {
    // Before Authentication
    Route::controller(HomeController::class)->group(function() {
        Route::get('/', 'index')->name('api_index');
        Route::get('/generate-token', 'generateToken')->name('api_generate_token');
        // Country
        Route::get('/country-list', 'countryList')->name('api_country_list');
        Route::get('/country-details/{id}', 'countryDetails')->name('api_country_details');
    });

    // Customer
    Route::controller(TemporaryUserController::class)->group(function() {
        // Signup
        Route::prefix('signup')->group(function () {
            Route::post('/step1', 'signupStep1')->name('api_signup_step1');
            
            Route::middleware('api.temporaryuser.token')->group(function () {
                Route::patch('/step2', 'signupStep2')->name('api_signup_step2');
                Route::patch('/step3', 'signupStep3')->name('api_signup_step3');
                Route::patch('/step4', 'signupStep4')->name('api_signup_step4');
            });
        });
        
    });

    
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
