<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;




Route::middleware(['guest'])->group(function () {
    Route::inertia("/register", "Auth/Register")->name('register');
    Route::inertia("/login", "Auth/Login")->name('login')->middleware('guest');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware(['auth'])->group(function () {
    Route::resource('/', UserController::class)->names(['index' => 'home']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::inertia("/about", "About", ["test"=> "hello About"])->name('about');
    Route::inertia("/dashboard", "Dashboard")->name('dashboard');

});

