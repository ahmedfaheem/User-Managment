<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $unverifiedUsers = User::whereNull('email_verified_at')->count();

        $recentUsers = User::query()
            ->latest()
            ->take(3)
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role' => $user->role,
                'status' => $user->status,
                'created_at' => $user->created_at?->toDateString(),
            ]);

        $roleBreakdown = User::query()
            ->select('role')
            ->selectRaw('count(*) as total')
            ->groupBy('role')
            ->orderBy('role')
            ->get()
            ->map(fn ($row) => [
                'role' => $row->role,
                'total' => $row->total,
            ]);

        return Inertia::render('Home', [
            'currentUser' => [
                'name' => $request->user()->name,
                'role' => $request->user()->role,
                'avatar' => $request->user()->avatar,
                'verified' => $request->user()->email_verified_at !== null,
                'joined_at' => $request->user()->created_at?->toDateString(),
            ],
            'stats' => [
                'totalUsers' => $totalUsers,
                'activeUsers' => $activeUsers,
                'inactiveUsers' => $inactiveUsers,
                'verifiedUsers' => $verifiedUsers,
                'unverifiedUsers' => $unverifiedUsers,
            ],
            'roleBreakdown' => $roleBreakdown,
            'recentUsers' => $recentUsers,
        ]);
    }
}
