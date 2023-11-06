<?php

namespace Database\Seeders;

use App\Models\CalculationType;
use Illuminate\Database\Seeder;

class CalculationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CalculationType::create([
            'calculation_type_name' => 'Market Research'
        ]);

        CalculationType::create([
            'calculation_type_name' => 'Preparation'
        ]);

        CalculationType::create([
            'calculation_type_name' => 'Implementation'
        ]);

        CalculationType::create([
            'calculation_type_name' => 'Evaluation'
        ]);

        CalculationType::create([
            'calculation_type_name' => 'Infrastructure'
        ]);

        CalculationType::create([
            'calculation_type_name' => 'Course Fee Student Enrollment'
        ]);

        CalculationType::create([
            'calculation_type_name' => 'Course Fee'
        ]);

        CalculationType::create([
            'calculation_type_name' => 'Certificate Fee Student Enrollment'
        ]);

        CalculationType::create([
            'calculation_type_name' => 'Certificate Fee'
        ]);
    }
}
