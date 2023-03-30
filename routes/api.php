<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Controllers
use App\Http\Controllers\api\TemporaryUserController;
use App\Http\Controllers\api\UserController;


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

    // Temporary Customer
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

    // Customer
    Route::controller(UserController::class)->group(function() {
        Route::patch('/forgot-passcode', 'forgotPasscode')->name('api_forgot_passcode');
        Route::patch('/verify-security-code', 'verifySecurityCode')->name('api_verify_security_code');
        Route::patch('/new-passcode', 'newPasscode')->name('api_new_passcode');
        Route::patch('/repeat-passcode', 'repeatPasscode')->name('api_repeat_passcode');
    });

    Route::middleware('api.token')->group(function () {
        // Auth
        Route::controller(UserController::class)->group(function() {
            Route::post('/log-in', 'logIn')->name('api_log_in');
            Route::get('/user-details', 'userDetails')->name('api_user_details');

            // Account creation API's
            Route::patch('/personal-details', 'personalDetails')->name('api_personal_details');
            Route::patch('/verify-profile-update-security-code', 'verifyProfileUpdateSecurityCode')->name('api_verify_profile_update_security_code');
            Route::patch('/send-profile-update-security-code', 'sendProfileUpdateSecurityCode')->name('api_send_profile_update_security_code');
            
            Route::post('/log-out', 'logOut')->name('api_log_out');
        });
        
        Route::controller(HomeController::class)->group(function() {
            Route::post('/support', 'support')->name('api_support');
        });



        // Route::post('/sign-in', 'UserController@signIn')->name('api_sign_in');
        // Route::post('/edit-profile-details', 'UserController@editProfileDetails')->name('api_edit_profile_details');
        // Route::post('/edit-profile', 'UserController@editProfile')->name('api_edit_profile');
        // Route::post('/change-password', 'UserController@changePassword')->name('api_change_password');
        // Route::post('/forgot-password', 'UserController@forgetPassword')->name('api_forget_password');
        // Route::post('/reset-password', 'UserController@resetPassword')->name('api_reset_password');

    });

    
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
