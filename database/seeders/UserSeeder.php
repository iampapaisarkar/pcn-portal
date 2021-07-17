<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'phone' => '+919002090020',
            'type' => null,
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'State',
            'lastname' => 'Offcie',
            'phone' => '+919002090020',
            'type' => null,
            'email' => 'state@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Pharmacy',
            'lastname' => 'Practice',
            'phone' => '+919002090020',
            'type' => null,
            'email' => 'pharmacy@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Registration',
            'lastname' => 'Licencing',
            'phone' => '+919002090020',
            'type' => null,
            'email' => 'licence@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor',
            'phone' => '+919002090020',
            'type' => null,
            'email' => 'vendor@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
            ],
        ]);
    }
}
