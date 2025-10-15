<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $query = User::with('roles');

        if (request('is_active') !== null) {
            $query->where('is_active', request('is_active') === '1');
        }

        if (request('role')) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', request('role'));
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['roles', 'orders', 'products', 'services']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_active' => 'nullable|boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function suspend(User $user)
    {
        $user->update(['is_active' => false]);

        return redirect()->back()
            ->with('success', 'User suspended successfully');
    }

    public function activate(User $user)
    {
        $user->update(['is_active' => true]);

        return redirect()->back()
            ->with('success', 'User activated successfully');
    }
}
