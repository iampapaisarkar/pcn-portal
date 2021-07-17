<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            [
            'role' => 'Super Admin',
            'code' => 'sadmin',
            ],
            [
            'role' => 'State Offcie',
            'code' => 'state_office',
            ],
            [
            'role' => 'Pharmacy Practice',
            'code' => 'pharmacy_practice',
            ],
            [
            'role' => 'Registration Licencing',
            'code' => 'registration_licencing',
            ],
            [
            'role' => 'Vendor',
            'code' => 'vendor',
            ],
        ]);
    }
}