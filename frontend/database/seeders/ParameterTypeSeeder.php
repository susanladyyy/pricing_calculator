<?php

namespace Database\Seeders;

use App\Models\ParameterType;
use Illuminate\Database\Seeder;

class ParameterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ParameterType::create([
            'parameter_type_name' => 'Single'
        ]);

        ParameterType::create([
            'parameter_type_name' => 'Multiple'
        ]);

        ParameterType::create([
            'parameter_type_name' => 'Result'
        ]);
    }
}
