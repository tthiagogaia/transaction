<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisteredUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    public function store(RegisteredUserRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::query()->create([
                'role_id'  => Role::query()->select('id')->where('label', Role::CONSUMER)->firstOrFail()->id,
                'name'     => $request->name,
                'cpf'      => $request->cpf,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->wallet()->create(['amount' => Wallet::DEFAULT_VALUE]);

            return $user;
        });
    }
}
