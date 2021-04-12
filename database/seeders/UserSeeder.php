<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::factory()->consumer()->create([
            'email'    => 'consumerone@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->wallet()->create(['amount' => Wallet::DEFAULT_VALUE]);

        $user = User::factory()->consumer()->create([
            'email'    => 'consumertwo@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->wallet()->create(['amount' => Wallet::DEFAULT_VALUE]);
    }
}
