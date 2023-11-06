<?php

namespace Database\Seeders;

use App\Models\Formula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder default formula for Maret Research
        Formula::create([
            'calculation_type_id' => 1,
            'version_id' => 1,
            'formula' => '1CMR / 1NCMR',
            'formula_name' => "Cost of Market Research/Visibility Study/Frontend Analysis, etc. / Number of Course(s) Formed from One Time Market Research",
        ]);

        // Seeder default formula for Preparation
        Formula::create([
            'calculation_type_id' => 2,
            'version_id' => 1,
            'formula' => 'R1 + 1CSME + 1MP',
            'formula_name' => "Cost of Market Research/Visibility Study/Frontend Analysis, etc. + Cost of SME's Salary for Course Materials Making + Multimedia Production",
        ]);

        // Seeder default formula for Implementation
        Formula::create([
            'calculation_type_id' => 3,
            'version_id' => 1,
            'formula' => '((1 / 1NCMR) * 1CME) + (CS * 1TFS) + 1TFCE',
            'formula_name' => "((1 / Number of Course(s) Formed from One Time Market Research) * Cost of marketing expense (marketing tools, advertisement, etc.)) + (Course Session * Tutor fee per session) + Tutor Fee for Course Assignment Evaluation",
        ]);

        // Seeder default formula for Evaluation
        Formula::create([
            'calculation_type_id' => 4,
            'version_id' => 1,
            'formula' => '1SMES + 1MPR',
            'formula_name' => "SME's salary for reviewing and evaluation course materials + Multimedia Production Revision",
        ]);

        // Seeder default formula for Infrastructure
        Formula::create([
            'calculation_type_id' => 5,
            'version_id' => 1,
            'formula' => '1CCE',
            'formula_name' => "Cost of cloud expense per user",
        ]);

        // Seeder default formula for Course Fee User Enrollment
        Formula::create([
            'calculation_type_id' => 6,
            'version_id' => 1,
            'formula' => '((1M1ACOC / (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))) / 1M1ESES)',
            'formula_name' => "((Cost of course / (((Cost of course + (Number of User (student) enrollment to reach Break Even Point * R5)) / Number of User (student) enrollment to reach Break Even Point) * ((100 + Profit Margin Percentage) / 100))) / Estimated User (student) enrollment per Semester)",
        ]);

        // Seeder default formula for Course Fee
        Formula::create([
            'calculation_type_id' => 7,
            'version_id' => 1,
            'formula' => '(((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))',
            'formula_name' => "(((Cost of course + (Number of User (student) enrollment to reach Break Even Point * R5)) / Number of User (student) enrollment to reach Break Even Point) * ((100 + Profit Margin Percentage) / 100))",
        ]);

        // Seeder default formula for Certificate Fee User Enrollment
        Formula::create([
            'calculation_type_id' => 8,
            'version_id' => 1,
            'formula' => '((1M2FCOC / (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))) / 1M2BESCS)',
            'formula_name' => "((Cost of course / (((Cost of course + (((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point) * Cost of cloud expense per user)) / ((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point)) * ((100 + Profit Margin Percentage) / 100))) / Estimated User (student) took Certificate per Semester)",
        ]);

        // Seeder default formula for Certificate Fee
        Formula::create([
            'calculation_type_id' => 9,
            'version_id' => 1,
            'formula' => '(((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))',
            'formula_name' => "(((Cost of course + (((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point) * Cost of cloud expense per user)) / ((1 / (Estimation Percentage of Enrollment Student will take Certificate / 100)) * Number of User (student) took Certificate to reach Break Even Point)) * ((100 + Profit Margin Percentage) / 100))",
        ]);
    }
}
