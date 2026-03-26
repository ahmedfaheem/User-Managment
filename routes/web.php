<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;

Route::get('/', function (Request $request) {
   // sleep(3);

    $count = $request->count;
    $users = User::when($request->search, function($query, $value){
        $query->where('name', 'like', '%'.$value.'%')->orWhere('email', 'like', '%'.$value.'%');
    })->paginate($count)->withQueryString()->through(fn ($user) => [
        'id' => $user->id,
        'avatar' => $user->avatar,
        'name' => $user->name,
        'email' => $user->email,
        'status' => $user->status,
        'role' => $user->role,
        'created_at' => $user->created_at,
        'can' => [
            'delete' => Auth::user()->can('delete', $user),
            'edit' => Auth::user()->can('update', $user),
        ],
    ]);
    return Inertia(
        'Home',
        [
            'users' => $users,
            'count' => $count,
            'search' => $request->search,

        ]);
})->name('home')->middleware('auth');

Route::inertia("/register", "Auth/Register")->name('register')->middleware('guest');
Route::inertia("/login", "Auth/Login")->name('login')->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::inertia("/about", "About", ["test"=> "hello About"])->name('about')->middleware('auth');
Route::inertia("/dashboard", "Dashboard")->name('dashboard')->middleware('auth');
