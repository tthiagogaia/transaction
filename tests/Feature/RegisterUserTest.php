<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class RegisterUserTest extends FeatureTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    public function test_it_should_be_able_to_register_new_user()
    {
        $this->postJson(route('register'), [
            'name'                  => 'Thiago Gabriel',
            'email'                 => 'tthiagogaia@gmail.com',
            'cpf'                   => '692.437.850-10',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])->assertSuccessful();
    }

    public function test_validate_all_fields_to_register_new_user()
    {
        $this->postJson(route('register'), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name'     => __('validation.required', ['attribute' => 'name']),
                'email'    => __('validation.required', ['attribute' => 'email']),
                'cpf'      => __('validation.required', ['attribute' => 'cpf']),
                'password' => __('validation.required', ['attribute' => 'password']),
            ]);

        $this->postJson(route('register'), [
            'name'                  => 'Thiago Gabriel',
            'email'                 => 'invalid',
            'cpf'                   => '000.000.000-00',
            'password'              => 'pas',
            'password_confirmation' => 'pas',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'email'    => __('validation.email', ['attribute' => 'email']),
                'cpf'      => __('Invalid CPF.'),
                'password' => __('validation.min.string', ['attribute' => 'password', 'min' => '8']),
            ]);

        User::factory()->consumer()->create([
            'cpf'   => '69243785010',
            'email' => 'tthiagogaia@gmail.com',
        ]);

        $this->postJson(route('register'), [
            'name'                  => Str::random(256),
            'email'                 => 'tthiagogaia@gmail.com',
            'cpf'                   => '692.437.850-10',
            'password'              => 'password',
            'password_confirmation' => 'passwordNotMatching',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name'     => __('validation.max.string', ['attribute' => 'name', 'max' => '255']),
                'email'    => __('validation.unique', ['attribute' => 'email']),
                'cpf'      => __('validation.unique', ['attribute' => 'cpf']),
                'password' => __('validation.confirmed', ['attribute' => 'password']),
            ]);
    }

    public function test_new_registered_user_has_consumer_role()
    {
        $response = $this->postJson(route('register'), [
            'name'                  => 'Thiago Gabriel',
            'email'                 => 'tthiagogaia@gmail.com',
            'cpf'                   => '692.437.850-10',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])->assertSuccessful();

        $this->assertEquals(
            $response->json('data.role_id'),
            Role::query()->select('id')->where('label', Role::CONSUMER)->firstOrFail()->id
        );
    }

    public function test_new_registered_user_has_default_wallet_value()
    {
        $response = $this->postJson(route('register'), [
            'name'                  => 'Thiago Gabriel',
            'email'                 => 'tthiagogaia@gmail.com',
            'cpf'                   => '692.437.850-10',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])->assertSuccessful();

        $newRegisteredUser = User::find($response->json('data.id'));

        $this->assertEquals(
            number_format(Wallet::DEFAULT_VALUE, 2),
            $newRegisteredUser->wallet->amount
        );
    }
}
