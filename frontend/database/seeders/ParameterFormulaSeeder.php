<?php

namespace Database\Seeders;

use App\Models\ParameterFormula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParameterFormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ParameterFormula::create([
            'parameter_id' => '1M1ACOC',
            'formula' => 'R2 + R3 + R4',
            'formula_name' => "R2 + R3 + R4",
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M1BCOST',
            'formula' => '((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP)',
            'formula_name' => "((Cost of course + (Number of User (student) enrollment to reach Break Even Point * R5)) / Number of User (student) enrollment to reach Break Even Point)"
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M1ECFP',
            'formula' => '(((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100)) * ((100 + 1M1DFIM) / 100)',
            'formula_name' => "(((Cost of course + (Number of User (student) enrollment to reach Break Even Point * R5)) / Number of User (student) enrollment to reach Break Even Point) * ((100 + Profit Margin Percentage) / 100)) * ((100 + Fee for ICE Membership Percentage per Semester) / 100)",
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M1FREVSEM',
            'formula' => '(ROUNDUP (1M1ACOC / (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))) * (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100)))',
            'formula_name' => "(Cost of course / (((Cost of course + (Number of User (student) enrollment to reach Break Even Point * R5)) / Number of User (student) enrollment to reach Break Even Point) * ((100 + Profit Margin Percentage) / 100))) * (((Cost of Course + (Number of User (student) enrollment to reach Break Even Point * R5)) / Number of User (student) enrollment to reach Break Even Point) * ((100 + Profit Margin Percentage) / 100))"
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M1GCFIM',
            'formula' => '((((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * (100 + 1M1CPMP) / 100) * (1M1DFIM / 100) * 1M1ESES)',
            'formula_name' => "((((Cost of Course + (Number of User (student) enrollment to reach Break Even Point * R5)) / Number of User (student) enrollment to reach Break Even Point) * (100 + Profit Margin Percentage) / 100) * (Fee for ICE Membership Percentage per Semester / 100) * Estimated User (student) enrollment per Semester)"
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M2DNUE',
            'formula' => '((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)',
            'formula_name' => "((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point)"
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M2ESES',
            'formula' => '(1 / (1M2CEESC / 100)) * 1M2BESCS',
            'formula_name' => "(1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Estimated User (student) took Certificate per Semester",
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M2FCOC',
            'formula' => 'R2 + R3 + R4',
            'formula_name' => "R2 + R3 + R4",
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M2GACS',
            'formula' => '((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP))',
            'formula_name' => "((Cost of course + (((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point) * Cost of cloud expense per user)) / ((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point))"
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M2IJECFP',
            'formula' => '((((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)) * ((100 + 1M2IFICEI) / 100))',
            'formula_name' => "((((Cost of course + (((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point) * Cost of cloud expense per user)) / ((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point)) * ((100 + Profit Margin Percentage) / 100)) * ((100 + Fee for ICE Membership Percentage per Semester) / 100))"
        ]);

        ParameterFormula::create([
            'parameter_id' => '1M2JREVSEM',
            'formula' => '(ROUNDUP (1M2FCOC / (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))) * (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)))',
            'formula_name' => "(Cost of course / (((Cost of course + (((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point) * Cost of cloud expense per user)) / ((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point)) * ((100 + Profit Margin Percentage) / 100))) * (((Cost of course + (((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point) * Cost of cloud expense per user)) / ((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point)) * ((100 + Profit Margin Percentage) / 100))",
        ]);


        ParameterFormula::create([
            'parameter_id' => '1M2KCFI',
            'formula' => '((((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)) * (1M2IFICEI / 100) * 1M2BESCS)',
            'formula_name' => "((((Cost of course + (((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point) * Cost of cloud expense per user)) / ((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point)) * ((100 + Profit Margin Percentage) / 100)) * (Fee for ICE Membership Percentage per Semester / 100) * Estimated User (student) took Certificate per Semester)",
        ]);
    }
}
