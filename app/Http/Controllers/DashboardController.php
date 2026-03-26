<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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
            'Dashboard',
            [
                'users' => $users,
                'totalUsers' => User::all()->count(),
                'activeUsers' => User::where('status', 'active')->count(),
                'roles' => User::distinct('role')->pluck('role'),
                'needVerifyCount' => User::where('email_verified_at', null)->count(),
                'filter'=>['search' => $request->search, 'count' => $pageCount, 'role' => $request->role ?? null],
            ]);
    }

}
