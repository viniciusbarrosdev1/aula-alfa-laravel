<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('admin/user/{user}', [UserController::class, 'show']);

Route::get('register', [UserController::class, 'register']);
Route::post('store', [UserController::class, 'create'])->name('users.store');

Route::get('forgot-password', [UserController::class, 'forgotPassword'])->name('password.forgot');
Route::post('forgot-password', [UserController::class, 'sendCode'])->name('password.send-code');

Route::get('verify-code', [UserController::class, 'verifyCodeForm'])->name('password.verify');
Route::post('verify-code', [UserController::class, 'verifyCode'])->name('password.verify-code');

Route::get('reset-password', [UserController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('reset-password', [UserController::class, 'changePassword'])->name('password.change');

Route::get('login', [UserController::class, 'loginForm'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login.attempt');
