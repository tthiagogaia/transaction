<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->consumer()->create([
            'email'    => 'consumerone@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->consumer()->create([
            'email'    => 'consumertwo@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
