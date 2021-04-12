<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\Role;
use App\Models\Wallet;

class CompanyController extends Controller
{
    public function store(CompanyRequest $request)
    {
        $company = Company::create([
            'name' => $request->name,
            'cnpj' => $request->cnpj,
        ]);

        $user          = auth()->user();
        $user->role_id = Role::query()
            ->select('id')
            ->where('label', Role::SHOPKEEPER)
            ->first()
            ->id;
        $user->save();

        $company->users()->attach($user);
        $company->wallet()->create(['amount' => Wallet::DEFAULT_VALUE]);

        return CompanyResource::make($company);
    }
}
