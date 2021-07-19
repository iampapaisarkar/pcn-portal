<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = array(
        array('id' => '2','name' => 'ABIA'),
        array('id' => '3','name' => 'ADAMAWA'),
        array('id' => '4','name' => 'ANAMBRA'),
        array('id' => '5','name' => 'AKWA IBOM'),
        array('id' => '6','name' => 'BAUCHI'),
        array('id' => '7','name' => 'BAYELSA'),
        array('id' => '8','name' => 'BENUE'),
        array('id' => '9','name' => 'BORNO'),
        array('id' => '10','name' => 'CROSS RIVER'),
        array('id' => '11','name' => 'DELTA'),
        array('id' => '12','name' => 'EBONYI'),
        array('id' => '13','name' => 'ENUGU'),
        array('id' => '14','name' => 'EDO'),
        array('id' => '15','name' => 'EKITI'),
        array('id' => '16','name' => 'GOMBE'),
        array('id' => '17','name' => 'IMO'),
        array('id' => '18','name' => 'JIGAWA'),
        array('id' => '19','name' => 'KADUNA'),
        array('id' => '20','name' => 'KANO'),
        array('id' => '21','name' => 'KATSINA'),
        array('id' => '22','name' => 'KEBBI'),
        array('id' => '23','name' => 'KOGI'),
        array('id' => '24','name' => 'KWARA'),
        array('id' => '25','name' => 'LAGOS'),
        array('id' => '26','name' => 'NASARAWA'),
        array('id' => '27','name' => 'NIGER'),
        array('id' => '28','name' => 'OGUN'),
        array('id' => '29','name' => 'ONDO'),
        array('id' => '30','name' => 'OSUN'),
        array('id' => '31','name' => 'OYO'),
        array('id' => '32','name' => 'PLATEAU'),
        array('id' => '33','name' => 'RIVERS'),
        array('id' => '34','name' => 'SOKOTO'),
        array('id' => '35','name' => 'TARABA'),
        array('id' => '36','name' => 'YOBE'),
        array('id' => '37','name' => 'ZAMFARA'),
        array('id' => '38','name' => 'FEDERAL CAPITAL TERRITORY (FCT)')
        );

        State::insert($states);
    }
}
