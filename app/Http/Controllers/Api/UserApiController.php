<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Users\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->paginate(10);

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,vendor,freelancer,client,support,super_admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $user->assignRole($request->role);

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        $user->load('profile', 'media');

        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|in:admin,vendor,freelancer,client,support,super_admin',
        ]);

        $user->update($request->only('name', 'email'));
        $user->syncRoles([$request->role]);

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        $user->load('profile', 'media');

        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'bio' => 'nullable|string',
            'skills' => 'nullable|array',
            'location' => 'nullable|string',
            'portfolio_url' => 'nullable|url',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = $user->profile ?: new Profile(['user_id' => $user->id]);
        $profile->fill($request->only('bio', 'skills', 'location', 'portfolio_url'));
        $profile->save();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $user->clearMediaCollection('avatar');
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return response()->json($user->load('profile', 'media'));
    }
}
