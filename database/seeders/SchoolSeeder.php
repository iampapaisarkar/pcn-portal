<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $School = [
            [
            'name' => 'School 1',
            'code' => 'school-1',
            'state' => 2,
            'status' => true
            ],
            [
            'name' => 'School 2',
            'code' => 'school-2',
            'state' => 2,
            'status' => true
            ],
            [
            'name' => 'School 3',
            'code' => 'school-3',
            'state' => 1,
            'status' => true
            ]
        ];

        School::insert($School);
    }
}
