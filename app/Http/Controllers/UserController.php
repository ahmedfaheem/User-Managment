<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageCount = $request->count ?? 10;
        $users = User::query()->when($request->search, function($query, $value){
            $query->where(function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%");
            });
        })->when($request->role && $request->role !== 'all' , function($query, $value) use ($request){
            $query->where('role', $request->role);
        })->paginate($pageCount)->withQueryString()->through(fn ($user) => [
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
                'totalUsers' => User::all()->count(),
                'activeUsers' => User::where('status', 'active')->count(),
                'roles' => User::distinct('role')->pluck('role'),
                'needVerifyCount' => User::where('email_verified_at', null)->count(),
                'filter'=>['search' => $request->search, 'count' => $pageCount, 'role' => $request->role ?? null],
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
