<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::query()->insert([
            [
                'name'  => 'Consumer',
                'label' => Role::CONSUMER,
            ],
            [
                'name'  => 'Shopkeeper',
                'label' => Role::SHOPKEEPER,
            ],
        ]);
    }
}
