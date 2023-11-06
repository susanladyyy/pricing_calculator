<?php

namespace Database\Seeders;

use App\Models\ChildParameter;
use Illuminate\Database\Seeder;

class ChildParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // cost of multimedia production
        ChildParameter::create([
            'parameter_id' => '1MP',
            'parameter_name' => 'Video Production',
            'parameter_cost' => 2500000,
            'parameter_number' => 13,
        ]);

        ChildParameter::create([
            'parameter_id' => '1MP',
            'parameter_name' => 'Audio Production',
            'parameter_cost' => 0,
            'parameter_number' => 0,
        ]);

        // total cost of multimedia revision
        ChildParameter::create([
            'parameter_id' => '1MPR',
            'parameter_name' => 'Video Production Revision',
            'parameter_cost' => 0,
            'parameter_number' => 0,
        ]);

        ChildParameter::create([
            'parameter_id' => '1MPR',
            'parameter_name' => 'New Video Production',
            'parameter_cost' => 0,
            'parameter_number' => 0,
        ]);
    }
}
