<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
    
    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
    
    Route::get('reverify', [AuthController::class, 'reverify'])->name('reverify');
    Route::post('post-reverify', [AuthController::class, 'postReverify'])->name('reverify.post'); 
    
    Route::post('build-twiml/user-input/{call_to}', [PhoneVerificationController::class, 'userInput']); 
    Route::post('/build-twiml/{call_to}/verification', [PhoneVerificationController::class, 'verifyNumber']); 
    

});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

});


Route::get('/', function () {
 
    
    return view('welcome');
});

