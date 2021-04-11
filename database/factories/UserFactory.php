<?php

namespace Database\Factories;

use App\Helpers\SanitizeHelper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $roles = Role::query()->select('id')->pluck('id');

        return [
            'role_id'           => $this->faker->randomElements($roles)[0],
            'name'              => $this->faker->name,
            'cpf'               => (new SanitizeHelper($this->faker->cpf))->cpfCnpj()->sanitize(),
            'email'             => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ];
    }

    public function consumer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => Role::query()->select('id')->where('label', Role::CONSUMER)->first()->id,
            ];
        });
    }

    public function shopkeeper()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => Role::query()->select('id')->where('label', Role::SHOPKEEPER)->first()->id,
            ];
        });
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
