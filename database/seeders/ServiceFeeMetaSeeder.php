<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceFee;

class ServiceFeeMetaSeeder extends Seeder
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
            'service_fee_id' => 'MEPTP Training Fees',
            'description' => 'MEPTP Training Fees',
            'amount' => 100,
            'status' => true,
            ],
        ];

        ServiceFee::insert($fees);
    }
}
