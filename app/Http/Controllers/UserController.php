<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
  public function index()
  {
    return response()->json([
      'users' => User::paginate(10, ['*'], 'users')->toArray()
    ]);
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
      return response()->json([
        'user' => $user
      ]);
    }
}
