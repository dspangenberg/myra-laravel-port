<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;

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
      'is_admin' => 'boolean'
    ]);

    $user->update($validated);

    return response()->json([
      'location' => $user
    ]);
  }

  public function store(Request $request, User $user)
  {
    $validated = $request->validate([
      'first_name' => 'required',
      'last_name' => 'required',
      'email' => ['required', Rule::unique('users')->ignore($user)],
      'avatar_url' => 'nullable|url',
      'is_admin' => 'boolean',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create($validated);

    return response()->json([
      'location' => $user
    ]);
  }

  public function show(User $user)
  {
    return new UserResource($user);
  }
}
