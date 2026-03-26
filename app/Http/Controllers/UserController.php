<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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


         return inertia('User/Edit', ["user" => $user, "permissions" => $user->getPermissionNames()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'email_verified_at' => ['nullable', 'date'],
            'avatar' => ['nullable', 'file', 'image', 'max:2048'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'bio' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.edit' => ['nullable', 'boolean'],
            'permissions.delete' => ['nullable', 'boolean'],
            'permissions.export' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->getRawOriginal('avatar')) {
                Storage::disk('public')->delete($user->getRawOriginal('avatar'));
            }

            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($validated['avatar']);
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => $validated['email_verified_at'] ?? null,
            'status' => $validated['status'],
            'role' => $validated['role'],
            'bio' => $validated['bio'] ?? null,
            ...(isset($validated['avatar']) ? ['avatar' => $validated['avatar']] : []),
        ]);


        $permissionMap = [
            'edit' => 'edit users',
            'delete' => 'delete users',
            'export' => 'export data',
        ];

        $permissions = collect($validated['permissions'] ?? [])
            ->filter()
            ->keys()
            ->map(fn (string $permission) => $permissionMap[$permission] ?? null)
            ->filter()
            ->values()
            ->all();

        $user->syncPermissions($permissions);

        return redirect()
            ->route('users.edit', $user)
            ->with('message', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        $user = User::find($user);

        if (! $user) {
            return redirect()
                ->back()
                ->withErrors(['delete'=>'User not found.']);
        }
        if($user->id == \Auth::user()->id) {
            return redirect()
                ->back()
                ->withErrors(['delete'=>'Can not Delete Yourself']);
        }

        $user->delete();

        return redirect()->route('dashboard')->with('message', 'User deleted successfully.');
    }
}
