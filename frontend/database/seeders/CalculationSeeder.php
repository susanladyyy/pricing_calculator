<?php

namespace Database\Seeders;

use App\Models\Calculation;
use Illuminate\Database\Seeder;

class CalculationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Calculation::create([
            'version_id' => 1,
            'calculation_type_id' => 1,
            'status' => false,
            'result' => 5000000,
        ]);

        Calculation::create([
            'version_id' => 1,
            'calculation_type_id' => 2,
            'status' => false,
            'result' => 42000000,
        ]);

        Calculation::create([
            'version_id' => 1,
            'calculation_type_id' => 3,
            'status' => false,
            'result' => 5500000,
        ]);

        Calculation::create([
            'version_id' => 1,
            'calculation_type_id' => 5,
            'status' => false,
            'result' => 100000,
        ]);
    }
}
