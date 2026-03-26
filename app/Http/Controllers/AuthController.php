<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AuthController extends Controller
{

    public function register(Request $request){

        $data =   $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required' ,'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:3', 'confirmed'],
            'avatar' => ['mimes:jpeg,jpg,png'],
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $user = User::create($data);
        Auth::login($user);



        return redirect()->route('home');

    }

    public function login(Request $request){
          $request->validate([
              'email' => ['required', 'string', 'email', 'max:255'],
              'password' => ['required', 'min:3'],
          ]);

           $credentials = $request->only('email', 'password');
           if (Auth::attempt($credentials, $request->remember)) { // allow remembered
               Inertia::flash('message', 'Login successfully!');
               return redirect()->intended();
           }

           return back()->withErrors([
               'email' => 'The provided credentials do not match our records.',

           ]);

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }



}
