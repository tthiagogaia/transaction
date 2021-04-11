<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Hash;

class LogoutTest extends FeatureTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    public function test_it_should_be_able_to_logout_authenticated_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->postJson('api/login', [
            'email'    => $user->email,
            'password' => 'password',
        ])
            ->assertSuccessful();

        $this->actingAs($user);

        $this->postJson('api/logout')->assertSuccessful();
    }
}
