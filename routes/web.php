<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
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

Route::get('/welcome', function () {
    return view('welcome');
});

require __DIR__.'/../routes/be.php';

require __DIR__.'/../routes/fe.php';


Route::get('register',[authController::class,'register'])->name('register');
Route::post('do-register',[authController::class,'doRegister'])->name('doRegister');

Route::get('login',[authController::class,'login'])->name('login');
Route::post('do-login',[authController::class,'doLogin'])->name('doLogin');
Route::post('logout',[authController::class,'logout'])->name('logout');

Route::get('/verification/{id}',[authController::class,'verification'])->name('verification');
Route::post('verified', [authController::class,'verifiedOTP'])->name('verifiedOTP');
Route::get('/resend-otp/{email}', [authController::class,'resendOTP'])->name('resendOTP');

Route::get('forgotPassword' , [authController::class,'forgotPassword'])->name('forgotPassword');

Route::post('handle-forgot-password', [authController::class, 'handleForgotPassword'])->name('handleForgotPassword');


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
