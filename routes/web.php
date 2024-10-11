<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

Route::get('/',[\App\Http\Controllers\HomeController::class,'index'])->middleware('auth')->name('home');
Route::get('/login',[LoginController::class,'login'])->middleware('guest')->name('login');
Route::post('/login',[LoginController::class,'authenticate'])->middleware('guest');
Route::post('/logout',[LoginController::class,'logout'])->middleware('auth')->name('logout');
Route::get('/signup-terms/',[\App\Http\Controllers\SignupController::class,'signup_terms'])->middleware('guest')->name('signup-terms');
Route::get('/signup-account/{code:code}',[\App\Http\Controllers\SignupController::class,'signup_account'])->middleware('guest')->name('signup-account');
Route::post('/handle-form', [SignupController::class, 'handleForm'])->name('handleForm');
Route::post('/signup-account/{code:code}', [SignupController::class, 'createUser'])->name('signup.create');
