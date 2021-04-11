<?php

namespace Database\Factories;

use App\Helpers\SanitizeHelper;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'cnpj' => (new SanitizeHelper($this->faker->cnpj))->cpfCnpj()->sanitize(),
        ];
    }
}
