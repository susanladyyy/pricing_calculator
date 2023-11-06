<?php

namespace Database\Seeders;

use App\Models\CalculationHistory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UniversitySeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            VersionSeeder::class,
            CalculationTypeSeeder::class,
            CalculationSeeder::class,
            ParameterTypeSeeder::class,
            ParameterSeeder::class,
            ChildParameterSeeder::class,
            FormulaSeeder::class,
            ParameterFormulaSeeder::class,
        ]);
    }
}
