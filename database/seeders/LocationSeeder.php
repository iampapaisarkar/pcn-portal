<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = array(
        array('name' => 'ABIA'),
        array('name' => 'ADAMAWA'),
        array('name' => 'AKWA IBOM'),
        array('name' => 'ANAMBRA'),
        array('name' => 'BAUCHI'),
        array('name' => 'BAYELSA'),
        array('name' => 'BENUE'),
        array('name' => 'BORNO'),
        array('name' => 'CROSS RIVER'),
        array('name' => 'DELTA'),
        array('name' => 'EBONYI'),
        array('name' => 'EDO'),
        array('name' => 'EKITI'),
        array('name' => 'ENUGU'),
        array('name' => 'GOMBE'),
        array('name' => 'IMO'),
        array('name' => 'JIGAWA'),
        array('name' => 'KADUNA'),
        array('name' => 'KANO'),
        array('name' => 'KATSINA'),
        array('name' => 'KEBBI'),
        array('name' => 'KOGI'),
        array('name' => 'KWARA'),
        array('name' => 'LAGOS'),
        array('name' => 'NASARAWA'),
        array('name' => 'NIGER'),
        array('name' => 'OGUN'),
        array('name' => 'ONDO'),
        array('name' => 'OYO'),
        array('name' => 'OSUN'),
        array('name' => 'OSUN'),
        array('name' => 'PLATEAU'),
        array('name' => 'RIVERS'),
        array('name' => 'SOKOTO'),
        array('name' => 'TARABA'),
        array('name' => 'YOBE'),
        array('name' => 'ZAMFARA')
        );
        
        Location::insert($locations);
    }
}
