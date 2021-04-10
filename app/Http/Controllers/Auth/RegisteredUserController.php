<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisteredUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function store(RegisteredUserRequest $request)
    {
        return User::query()->create([
            'name'     => $request->name,
            'cpf'      => $request->cpf,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
