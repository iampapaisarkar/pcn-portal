<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Batch = [
            [
            'batch_no' => 3,
            'year' => '2021',
            'status' => true,
            'updated_at' => now()
            ],
            [
            'batch_no' => 3,
            'year' => '2021',
            'status' => false,
            'updated_at' => now()
            ],
            [
            'batch_no' => 1,
            'year' => '2021',
            'status' => false,
            'updated_at' => now()
            ],
        ];

        Batch::insert($Batch);
    }
}
