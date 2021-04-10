<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisteredUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function store(RegisteredUserRequest $request)
    {
        return User::query()->create([
            'role_id'  => Role::query()->select('id')->where('label', Role::CONSUMER)->firstOrFail()->id,
            'name'     => $request->name,
            'cpf'      => $request->cpf,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
