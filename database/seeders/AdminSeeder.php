<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Domain\Customers\Models\Customer;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret123'),
            'is_admin' => true,
        ]);
    }
}
