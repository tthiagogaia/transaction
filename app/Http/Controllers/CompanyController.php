<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Role;

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

        return $company;
    }
}
