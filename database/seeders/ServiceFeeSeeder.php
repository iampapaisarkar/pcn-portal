<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceFee;

class ServiceFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fees = [
            [
            'description' => 'MEPTP Training Fees',
            ],
            [
            'description' => 'Tiered PPMV Registration Fees',
            ],
            [
            'description' => 'Tiered PPMV Renewal Fees',
            ],
        ];

        ServiceFee::insert($fees);
    }
}
