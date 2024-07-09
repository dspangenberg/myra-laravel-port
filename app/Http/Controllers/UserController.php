<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Resources\UserResource;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::query()
            ->orderBy('last_name')
            ->paginate($this->recordsPerPage)
        );
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user)],
            'avatar_url' => 'nullable|url',
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        $user->update($validated);

        return response()->json([
            'location' => $user,
        ]);
    }

    public function store(StoreUser $request, User $user)
    {
        $user->update($request->validated());

        return response()->json([
            'user' => $user,
        ]);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
}
