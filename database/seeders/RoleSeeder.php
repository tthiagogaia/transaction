<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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
