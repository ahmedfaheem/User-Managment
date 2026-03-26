<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $roles = User::query()
            ->select('role')
            ->selectRaw('count(*) as total')
            ->groupBy('role')
            ->orderBy('role')
            ->get()
            ->map(fn ($row) => [
                'role' => $row->role,
                'total' => $row->total,
            ]);

        $latestMembers = User::query()
            ->latest()
            ->take(4)
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

        return Inertia::render('About', [
            'stats' => [
                'totalUsers' => $totalUsers,
                'activeUsers' => $activeUsers,
                'verifiedUsers' => $verifiedUsers,
                'rolesCount' => $roles->count(),
            ],
            'roles' => $roles,
            'latestMembers' => $latestMembers,
        ]);
    }
}
