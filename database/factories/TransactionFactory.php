<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Operation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'payer_id'           => User::factory(),
            'operation_id'       => Operation::factory(),
            'authorization_code' => Str::random(),
            'payee_id'           => Company::factory(),
            'payee_type'         => Company::class,
            'refunded_at'        => $this->faker->randomElement([now(), null]),
        ];
    }
}
