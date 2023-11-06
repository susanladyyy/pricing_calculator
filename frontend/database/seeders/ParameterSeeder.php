<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // market research default
        Parameter::create([
            'id' => '1CMR',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 1,
            'parameter_name' => 'Cost of Market Research/Visibility Study/Frontend Analysis, etc.',
            'parameter_content' => 100000000,
        ]);

        Parameter::create([
            'id' => '1NCMR',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 1,
            'parameter_name' => 'Number of Course(s) Formed from One Time Market Research',
            'parameter_content' => 20,
        ]);

        // preparation default
        Parameter::create([
            'id' => '1CSME', //3
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 2,
            'parameter_name' => "Cost of SME's Salary for Course Materials Making",
            'parameter_content' => 4500000,
        ]);

        Parameter::create([
            'id' => '1MP', //4
            'version_id' => 1,
            'parameter_type_id' => 2,
            'calculation_type_id' => 2,
            'parameter_name' => "Multimedia Production",
            'parameter_content' => 32500000,
        ]);

        // implementation default
        Parameter::create([
            'id' => '1CME', //5
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 3,
            'parameter_name' => "Cost of marketing expense (marketing tools, advertisement, etc.)",
            'parameter_content' => 50000000,
        ]);

        Parameter::create([
            'id' => '1TFS',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 3,
            'parameter_name' => "Tutor fee per session (input 0 if there is no tutor fee)",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1TFCE',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 3,
            'parameter_name' => "Tutor Fee for Course Assignment Evaluation",
            'parameter_content' => 2500000,
        ]);

        // evaluation default
        Parameter::create([
            'id' => '1SMES',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 4,
            'parameter_name' => "SME's salary for reviewing and evaluation course materials",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1MPR',
            'version_id' => 1,
            'parameter_type_id' => 2,
            'calculation_type_id' => 4,
            'parameter_name' => "Multimedia Production Revision",
            'parameter_content' => 0,
        ]);

        // infrastructure default
        Parameter::create([
            'id' => '1CCE', //10
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 5,
            'parameter_name' => "Cost of cloud expense per user",
            'parameter_content' => 100000,
        ]);

        // course fee default
        Parameter::create([
            'id' => '1M1ANUEBEP',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 6,
            'parameter_name' => "Number of User (student) enrollment to reach Break Even Point",
            'parameter_content' => 533,
        ]);

        Parameter::create([
            'id' => '1M1ESES',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 6,
            'parameter_name' => "Estimated User (student) enrollment per Semester",
            'parameter_content' => 90,
        ]);

        // 13
        Parameter::create([
            'id' => '1M1ACOC',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Cost of course",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M1BCOST',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Assumption Cost per student",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M1CPMP',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 7,
            'parameter_name' => "Profit Margin Percentage",
            'parameter_content' => 15,
        ]);

        Parameter::create([
            'id' => '1M1DFIM',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 7,
            'parameter_name' => "Fee for ICE Membership Percentage per Semester",
            'parameter_content' => 15,
        ]);

        Parameter::create([
            'id' => '1M1ECFP',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Course Fee Paid by Students",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M1FREVSEM',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Total Revenue",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M1GCFIM',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Cost of Fee for ICEI Membership per Semester",
            'parameter_content' => 0,
        ]);

        // certificate fee default 18
        Parameter::create([
            'id' => '1M2ANUEBEP',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 8,
            'parameter_name' => "Number of User (student) took Certificate to reach Break Even Point",
            'parameter_content' => 480,
        ]);

        Parameter::create([
            'id' => '1M2BESCS',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 8,
            'parameter_name' => "Estimated User (student) took Certificate per Semester",
            'parameter_content' => 90,
        ]);

        Parameter::create([
            'id' => '1M2CEESC',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 8,
            'parameter_name' => "Estimation Percentage of Enrollment Student will take Certificate",
            'parameter_content' => 90,
        ]);

        Parameter::create([
            'id' => '1M2DNUE', //21
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 8,
            'parameter_name' => "Number of User (student) enrollment",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M2ESES', //22
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 8,
            'parameter_name' => "Estimated User (student) Enrollment per Semester",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M2FCOC',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Cost of course",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M2GACS',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Assumption Cost per Student",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M2HPMP',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 9,
            'parameter_name' => "Profit Margin Percentage",
            'parameter_content' => 15,
        ]);

        Parameter::create([
            'id' => '1M2IFICEI',
            'version_id' => 1,
            'parameter_type_id' => 1,
            'calculation_type_id' => 9,
            'parameter_name' => "Fee for ICE Membership Percentage per Semester",
            'parameter_content' => 15,
        ]);

        Parameter::create([
            'id' => '1M2IJECFP',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Course Fee Paid by Students",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M2JREVSEM',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Total Revenue",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => '1M2KCFI',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Cost of Fee for ICEI Membership per Semester",
            'parameter_content' => 0,
        ]);
    }
}
