<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $user = User::query()->where('email', $request->email)->first();

        if ($user === null) {
            return response(['message' => __('Invalid credentials')], Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response(['message' => __('Invalid credentials')], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('FRONT_END');

        return ['token' => $token->plainTextToken];
    }

    public function destroy()
    {
        auth()->user()->tokens()->delete();
    }
}
