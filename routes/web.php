<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;


Route::middleware(['guest'])->group(function () {
    Route::inertia("/register", "Auth/Register")->name('register');
    Route::inertia("/login", "Auth/Login")->name('login')->middleware('guest');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get("/dashboard", [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
});

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/export-users', function () {
    return Excel::download(new UsersExport, 'users.xlsx');
})->name('export-users')->middleware('auth', 'IsAdmin');
