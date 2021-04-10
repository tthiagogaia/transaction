<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginTest extends FeatureTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    public function test_it_should_be_able_to_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->postJson('api/login', [
            'email'    => $user->email,
            'password' => 'password',
        ])
            ->assertSuccessful();
    }

    public function test_validate_all_fields_to_login()
    {
        $this->postJson('api/login', [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'email'    => __('validation.required', ['attribute' => 'email']),
                'password' => __('validation.required', ['attribute' => 'password']),
            ]);

        $this->postJson('api/login', [
            'email'    => 'invalid',
            'password' => 'anyPassword',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'email' => __('validation.email', ['attribute' => 'email']),
            ]);
    }

    public function test_validate_wrong_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->postJson('api/login', [
            'email'    => $user->email,
            'password' => 'wrongPassword',
        ])
            ->assertJson(['message' => __('Invalid credentials')])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->postJson('api/login', [
            'email'    => 'wrong_email@gmail.com',
            'password' => 'password',
        ])
            ->assertJson(['message' => __('Invalid credentials')])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
