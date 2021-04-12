<?php

namespace Database\Factories;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperationFactory extends Factory
{
    protected $model = Operation::class;

    public function definition()
    {
        return [
            'type'   => Operation::CREDIT,
            'amount' => $this->faker->numberBetween(1, 100),
        ];
    }
}
