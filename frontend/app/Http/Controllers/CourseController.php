<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use App\Models\ChildParameter;
use App\Models\Course;
use App\Models\Formula;
use App\Models\Parameter;
use App\Models\ParameterFormula;
use App\Models\University;
use App\Models\User;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $university = Auth::user()->university;
        $courses = $university->courses()->paginate(5);

        if (Auth::user()->role_id == 1) {
            $user = User::with('university')->get();
            $university = University::all();

            return view('admin.admin', compact('user', 'university'));
        } else {
            return view('courses.courses', compact('courses'));
        }
    }

    public function insertCourseView()
    {
        return view('courses.insert-course');
    }

    private function generateParameters($id)
    {
        $CMR = Parameter::create([
            'id' => $id . 'CMR',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 1,
            'parameter_name' => 'Cost of Market Research/Visibility Study/Frontend Analysis, etc.',
            'parameter_content' => 0,
        ]);

        $NCMR = Parameter::create([
            'id' => $id . 'NCMR',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 1,
            'parameter_name' => 'Number of Course(s) Formed from One Time Market Research',
            'parameter_content' => 0,
        ]);

        // preparation default
        $CSME = Parameter::create([
            'id' => $id . 'CSME',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 2,
            'parameter_name' => "Cost of SME's Salary for Course Materials Making",
            'parameter_content' => 0,
        ]);

        $MP = Parameter::create([
            'id' => $id . 'MP',
            'version_id' => $id,
            'parameter_type_id' => 2,
            'calculation_type_id' => 2,
            'parameter_name' => "Multimedia Production",
            'parameter_content' => 0,
        ]);

        ChildParameter::create([
            'parameter_id' => $MP->id,
            'parameter_name' => 'Video Production',
            'parameter_cost' => 0,
            'parameter_number' => 0,
        ]);

        ChildParameter::create([
            'parameter_id' => $MP->id,
            'parameter_name' => 'Audio Production',
            'parameter_cost' => 0,
            'parameter_number' => 0,
        ]);

        // implementation default
        $CME = Parameter::create([
            'id' => $id . 'CME',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 3,
            'parameter_name' => "Cost of marketing expense (marketing tools, advertisement, etc.)",
            'parameter_content' => 0,
        ]);

        $TFS = Parameter::create([
            'id' => $id . 'TFS',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 3,
            'parameter_name' => "Tutor fee per session (input 0 if there is no tutor fee)",
            'parameter_content' => 0,
        ]);

        $TFCE = Parameter::create([
            'id' => $id . 'TFCE',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 3,
            'parameter_name' => "Tutor fee for course assignment evaluation",
            'parameter_content' => 0,
        ]);

        // evaluation default
        $SMES = Parameter::create([
            'id' => $id . 'SMES',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 4,
            'parameter_name' => "SME's salary for reviewing and evaluation course materials",
            'parameter_content' => 0,
        ]);

        $MPR = Parameter::create([
            'id' => $id . 'MPR',
            'version_id' => $id,
            'parameter_type_id' => 2,
            'calculation_type_id' => 4,
            'parameter_name' => "Multimedia Revision",
            'parameter_content' => 0,
        ]);

        ChildParameter::create([
            'parameter_id' => $MPR->id,
            'parameter_name' => 'Video Production Revision',
            'parameter_cost' => 0,
            'parameter_number' => 0,
        ]);

        ChildParameter::create([
            'parameter_id' => $MPR->id,
            'parameter_name' => 'New Video Production',
            'parameter_cost' => 0,
            'parameter_number' => 0,
        ]);

        // infrastructure default
        $CCE = Parameter::create([
            'id' => $id . 'CCE',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 5,
            'parameter_name' => "Cost of cloud expense per user",
            'parameter_content' => 0,
        ]);

        // course fee default
        $M1ANUEBEP = Parameter::create([
            'id' => $id . 'M1ANUEBEP',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 6,
            'parameter_name' => "Number of User (student) enrollment to reach Break Even Point",
            'parameter_content' => 0,
        ]);

        $M1ESES = Parameter::create([
            'id' => $id . 'M1ESES',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 6,
            'parameter_name' => "Estimated User (student) enrollment per Semester",
            'parameter_content' => 0,
        ]);

        $M1ACOC = Parameter::create([
            'id' => $id . 'M1ACOC',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Cost of course",
            'parameter_content' => 0,
        ]);

        $M1BCOST = Parameter::create([
            'id' => $id . 'M1BCOST',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Assumption Cost per student",
            'parameter_content' => 0,
        ]);

        $M1CPMP = Parameter::create([
            'id' => $id . 'M1CPMP',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 7,
            'parameter_name' => "Profit Margin Percentage",
            'parameter_content' => 0,
        ]);

        $M1DFIM = Parameter::create([
            'id' => $id . 'M1DFIM',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 7,
            'parameter_name' => "Fee for ICE Membership Percentage per Semester",
            'parameter_content' => 0,
        ]);

        $M1ECFP = Parameter::create([
            'id' => $id . 'M1ECFP',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Course Fee Paid by Students",
            'parameter_content' => 0,
        ]);

        $M1FREVSEM = Parameter::create([
            'id' => $id . 'M1FREVSEM',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Revenue per Semester",
            'parameter_content' => 0,
        ]);

        $M1GCFIM = Parameter::create([
            'id' => $id . 'M1GCFIM',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Cost of Fee for ICEI Membership per Semester",
            'parameter_content' => 0,
        ]);

        // certificate fee default
        $M2ANUEBEP = Parameter::create([
            'id' => $id . 'M2ANUEBEP',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 8,
            'parameter_name' => "Number of User (student) took Certificate to reach Break Even Point",
            'parameter_content' => 0,
        ]);

        $M2BESCS = Parameter::create([
            'id' => $id . 'M2BESCS',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 8,
            'parameter_name' => "Estimated User (student) took Certificate per Semester",
            'parameter_content' => 0,
        ]);

        $M2CEESC = Parameter::create([
            'id' => $id . 'M2CEESC',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 8,
            'parameter_name' => "Estimation Percentage of Enrollment Student will take Certificate",
            'parameter_content' => 0,
        ]);

        $M2DNUE = Parameter::create([
            'id' => $id . 'M2DNUE',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 8,
            'parameter_name' => "Number of User (student) enrollment",
            'parameter_content' => 0,
        ]);

        $M2ESES = Parameter::create([
            'id' => $id . 'M2ESES',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 8,
            'parameter_name' => "Estimated User (student) Enrollment per Semester",
            'parameter_content' => 0,
        ]);

        $M2FCOC = Parameter::create([
            'id' => $id . 'M2FCOC',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Cost of course",
            'parameter_content' => 0,
        ]);

        $M2GACS = Parameter::create([
            'id' => $id . 'M2GACS',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Assumption Cost per Student",
            'parameter_content' => 0,
        ]);

        $M2HPMP = Parameter::create([
            'id' => $id . 'M2HPMP',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 9,
            'parameter_name' => "Profit Margin Percentage",
            'parameter_content' => 0,
        ]);

        $M2IFICEI = Parameter::create([
            'id' => $id . 'M2IFICEI',
            'version_id' => $id,
            'parameter_type_id' => 1,
            'calculation_type_id' => 9,
            'parameter_name' => "Fee for ICE Membership Percentage per Semester",
            'parameter_content' => 0,
        ]);

        Parameter::create([
            'id' => $id . 'M2IJECFP',
            'version_id' => 1,
            'parameter_type_id' => 3,
            'calculation_type_id' => 7,
            'parameter_name' => "Course Fee Paid by Students",
            'parameter_content' => 0,
        ]);

        $M2JREVSEM = Parameter::create([
            'id' => $id . 'M2JREVSEM',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Total Revenue",
            'parameter_content' => 0,
        ]);

        $M2KCFI = Parameter::create([
            'id' => $id . 'M2KCFI',
            'version_id' => $id,
            'parameter_type_id' => 3,
            'calculation_type_id' => 9,
            'parameter_name' => "Cost of Fee for ICEI Membership per Semester",
            'parameter_content' => 0,
        ]);
    }

    private function generateFormula($id)
    {
        Formula::create([
            'calculation_type_id' => 1,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '1CMR / 1NCMR')
        ]);

        // Seeder default formula for Preparation
        Formula::create([
            'calculation_type_id' => 2,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, 'R1 + 1CSME + 1MP')
        ]);

        // Seeder default formula for Implementation
        Formula::create([
            'calculation_type_id' => 3,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((1 / 1NCMR) * 1CME) + (CS * 1TFS) + 1TFCE')
        ]);

        // Seeder default formula for Evaluation
        Formula::create([
            'calculation_type_id' => 4,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, 'SMES + 1MPR')
        ]);

        // Seeder default formula for Infrastructure
        Formula::create([
            'calculation_type_id' => 5,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '1CCE')
        ]);

        // Seeder default formula for Course Fee User Enrollment
        Formula::create([
            'calculation_type_id' => 6,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((1M1ACOC / (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))) / 1M1ESES)')
        ]);

        // Seeder default formula for Course Fee
        Formula::create([
            'calculation_type_id' => 7,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '(((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))')
        ]);

        // Seeder default formula for Certificate Fee User Enrollment
        Formula::create([
            'calculation_type_id' => 8,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((1M2FCOC / (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))) / 1M2BESCS)')
        ]);

        // Seeder default formula for Certificate Fee
        Formula::create([
            'calculation_type_id' => 9,
            'version_id' => $id,
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '(((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))')
        ]);

        // Formula for Model
        ParameterFormula::create([
            'parameter_id' => $id . 'M1ACOC',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, 'R2 + R3 + R4')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M1BCOST',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP)')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M1ECFP',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '(((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100)) * ((100 + 1M1DFIM) / 100)')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M1FREVSEM',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '(ROUNDUP (1M1ACOC / (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))) * (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100)))')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M1GCFIM',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * (100 + 1M1CPMP) / 100) * (1M1DFIM / 100) * 1M1ESES)')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M2DNUE',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M2ESES',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '(1 / (1M2CEESC / 100)) * 1M2BESCS')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M2FCOC',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, 'R2 + R3 + R4')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M2GACS',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP))')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M2IJECFP',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)) * ((100 + 1M2IFICEI) / 100))')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M2JREVSEM',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '(ROUNDUP (1M2FCOC / (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))) * (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)))')
        ]);

        ParameterFormula::create([
            'parameter_id' => $id . 'M2KCFI',
            'formula' => preg_replace('/\b1(?![0-9])/', $id, '((((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)) * (1M2IFICEI / 100) * 1M2BESCS)')
        ]);
    }

    public function insertCourse(Request $request)
    {

        $validated = $request->validate([
            'courseName' => 'required',
            'numberOfSession' => 'required|numeric',
        ]);

        $new_course = Course::create([
            'course_name' => $validated['courseName'],
            'session_number' => $validated['numberOfSession'],
            'university_id' => Auth::user()->university_id,
        ]);

        $new_version = Version::create([
            'course_id' => $new_course->id,
            'course_version' => 1
        ]);

        // Generate parameter for a new version
        $this->generateParameters($new_version->id);

        // formula
        $this->generateFormula($new_version->id);

        // calculation
        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 1,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 2,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 3,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 4,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 5,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 6,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 7,
            'result' => 0,
            'status' => false,
        ]);

        return redirect()->intended('/');
    }

    public function insertNewVersion(Request $request)
    {
        $id = $request->courseId;
        $version = Version::where('course_id', $id)->max('course_version');

        $new_version = Version::create([
            'course_id' => $id,
            'course_version' => $version + 1,
        ]);

        // Generate parameter for a new version
        $this->generateParameters($new_version->id);

        // formula
        // Seeder default formula for Maret Research
        Formula::create([
            'calculation_type_id' => 1,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, 'CMR / 1NCMR')
        ]);

        // Seeder default formula for Preparation
        Formula::create([
            'calculation_type_id' => 2,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, 'R1 + 1CSME + 1MP')
        ]);

        // Seeder default formula for Implementation
        Formula::create([
            'calculation_type_id' => 3,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '((1 / 1NCMR) * 1CME) + (CS * 1TFS) + 1TFCE')
        ]);

        // Seeder default formula for Evaluation
        Formula::create([
            'calculation_type_id' => 4,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, 'SMES + 1MPR')
        ]);

        // Seeder default formula for Infrastructure
        Formula::create([
            'calculation_type_id' => 5,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, 'CCE')
        ]);

        // Seeder default formula for Course Fee User Enrollment
        Formula::create([
            'calculation_type_id' => 6,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '((1M1ACOC / (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))) / 1M1ESES)')
        ]);

        // Seeder default formula for Course Fee
        Formula::create([
            'calculation_type_id' => 7,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '(((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))')
        ]);

        // Seeder default formula for Certificate Fee User Enrollment
        Formula::create([
            'calculation_type_id' => 8,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '((1M2FCOC / (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))) / 1M2BESCS)')
        ]);

        // Seeder default formula for Certificate Fee
        Formula::create([
            'calculation_type_id' => 9,
            'version_id' => $new_version->id,
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '(((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))')
        ]);

        // Formula for Model
        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M1ACOC',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, 'R2 + R3 + R4')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M1BCOST',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP)')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M1ECFP',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '(((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100)) * ((100 + 1M1DFIM) / 100)')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M1FREVSEM',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '(ROUNDUP (1M1ACOC / (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100))) * (((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * ((100 + 1M1CPMP) / 100)))')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M1GCFIM',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '((((1M1ACOC + (1M1ANUEBEP * R5)) / 1M1ANUEBEP) * (100 + 1M1CPMP) / 100) * (1M1DFIM / 100) * 1M1ESES)')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M2DNUE',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M2ESES',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '(1 / (1M2CEESC / 100)) * 1M2BESCS')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M2FCOC',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, 'R2 + R3 + R4')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M2GACS',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP))')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M2JREVSEM',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '(ROUNDUP (1M2FCOC / (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100))) * (((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)))')
        ]);

        ParameterFormula::create([
            'parameter_id' => $new_version->id . 'M2KCFI',
            'formula' => preg_replace('/\b1(?![0-9])/', $new_version->id, '((((1M2FCOC + (((1 / (1M2CEESC / 100)) * 1M2ANUEBEP) * 1CCE)) / ((1 / (1M2CEESC / 100)) * 1M2ANUEBEP)) * ((100 + 1M2HPMP) / 100)) * (1M2IFICEI / 100) * 1M2BESCS)')
        ]);

        // calculation
        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 1,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 2,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 3,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 4,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 5,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 6,
            'result' => 0,
            'status' => false,
        ]);

        Calculation::create([
            'version_id' => $new_version->id,
            'calculation_type_id' => 7,
            'result' => 0,
            'status' => false,
        ]);

        return redirect()->back();
    }

    public function updateCourseView($id)
    {
        $version = Version::where('id', $id)->first();
        $course = Course::where('id', $version->course_id)->first();

        return view('courses.update-course', compact('course', 'version'));
    }

    public function updateCourse(Request $request, $id)
    {
        $version = Version::where('id', $id)->first();
        $course = Course::where('id', $version->course_id)->first();

        $validated = $request->validate([
            'courseName' => 'required',
            'numberOfSession' => 'required|numeric',
        ]);

        $course->update([
            'course_name' => $validated['courseName'],
            'session_number' => $validated['numberOfSession'],
        ]);

        $url = '/detail/' . $id;
        return redirect()->intended($url);
    }

    public function deleteCourse($id)
    {
        Course::where('id', $id)->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }

    public function searchCourse(Request $request)
    {
        $query = $request->input('search_course');
        $courses = Course::where('course_name', 'like', '%' . $query . '%')->get();

        $tableRows = [];
        foreach ($courses as $c) {
            $tableRow = '<div class="accordion rounded-t rounded-b" id="accordion-' . $c->id . '">';
            $tableRow .= '<h2 class="accordion-heading">';
            $tableRow .= '<button type="button" class="flex items-center justify-between w-full p-5 text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800">';
            $tableRow .= '<span class="font-semibold text-md text-black">' . $c->course_name . '</span>';
            $tableRow .= '<div class="flex items-center gap-x-[2vw]">';
            $tableRow .= '<form method="POST" action="' . route('insertNewVersion') . '" class="bg-primary text-white px-[1vw] py-[1vh] rounded-md shadow-md mr-10">';
            $tableRow .= csrf_field();
            $tableRow .= '<input type="hidden" name="courseId" value="' . $c->id . '" />';
            $tableRow .= '<input type="submit" value="Add New Version" class="cursor-pointer"/>';
            $tableRow .= '</form>';
            $tableRow .= '<svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">';
            $tableRow .= '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1 5 5 9 1" />';
            $tableRow .= '</svg>';
            $tableRow .= '</div>';
            $tableRow .= '</button>';
            $tableRow .= '</h2>';
            $tableRow .= '<div class="accordion-body hidden">';
            foreach ($c->courseVersions as $v) {
                $tableRow .= '<div class="px-[3vw] py-[2vh] border border-gray-200 dark:border-gray-700 dark:bg-gray-900 flex justify-between items-center">';
                $tableRow .= '<div class="left">';
                $tableRow .= '<p class="font-semibold mb-2 text-gray-500 dark:text-gray-400">Version Number : ' . $v->course_version . '</p>';
                $tableRow .= '</div>';
                $tableRow .= '<div class="right">';
                $tableRow .= '<a href="' . route('detail', $v) . '"><i class="text-primary fa-solid fa-arrow-right-long"></i></a>';
                $tableRow .= '</div>';
                $tableRow .= '</div>';
            }
            $tableRow .= '</div>';
            $tableRow .= '</div>';
            $tableRows[] = $tableRow;
        }

        return response()->json(['table_rows' => $tableRows]);
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('search_user');
        $users = User::where('username', 'like', '%' . $query . '%')->get();

        $tableRows = '';
        foreach ($users as $u) {
            $tableRows .= '<tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600" id="user-' . $u->id . '">';
            $tableRows .= '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
            $tableRows .= $u->username . '</th>';
            $tableRows .= '<td class="px-6 py-4">';
            $tableRows .= $u->email . '</td>';
            $tableRows .= '<td class="px-6 py-4">';
            $tableRows .= $u->university->university_name . '</td>';
            $tableRows .= '<td class="px-6 py-4 text-right">';
            $tableRows .= '<a href="' . route('updateUser', ['id' => $u->id]) . '" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i class="text-2xl text-blue-500 fa-solid fa-pencil"></i></a>';
            $tableRows .= '<a onclick="deleteUser(' . $u->id . ')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-[1vw]"><i class="text-2xl text-red-600 fa-regular fa-trash-can cursor-pointer"></i></a>';
            $tableRows .= '</td>';
            $tableRows .= '</tr>';
        }

        return response()->json(['table_rows' => $tableRows]);
    }

    public function searchUniversity(Request $request)
    {
        $query = $request->input('search_university');
        $universities = University::where('university_name', 'like', '%' . $query . '%')->get();

        $tableRows = '';
        foreach ($universities as $uni) {
            $tableRows .= '<tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600" id="university-' . $uni->id . '">';
            $tableRows .= '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
            $tableRows .= $uni->university_name . '</th>';
            $tableRows .= '<td class="px-6 py-4">';
            $tableRows .= $uni->university_address . '</td>';
            $tableRows .= '<td class="px-6 py-4">';
            $tableRows .= '<img src="' . $uni->logo_path . '" alt="" class="w-35 h-12 mr-2">';
            $tableRows .= '</td>';
            $tableRows .= '<td class="px-6 py-4 text-right">';
            $tableRows .= '<a href="' . route('updateUniversity', ['id' => $uni->id]) . '" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i class="text-2xl text-blue-500 fa-solid fa-pencil"></i></a>';
            $tableRows .= '<a onclick="deleteUniversity(' . $uni->id . ')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-[1vw]"><i class="text-2xl text-red-600 fa-regular fa-trash-can cursor-pointer"></i></a>';
            $tableRows .= '</td>';
            $tableRows .= '</tr>';
        }

        return response()->json(['table_rows' => $tableRows]);
    }
}
