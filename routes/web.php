<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AuthAdmin;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware([Auth::class,AuthUser::class])->group(function(){
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});


Route::middleware([AuthAdmin::class])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});