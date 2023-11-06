<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CalculationType;
use App\Models\ChildParameterHistory;
use App\Models\Course;
use App\Models\Formula;
use App\Models\History;
use App\Models\HistoryDetail;
use App\Models\Parameter;
use App\Models\ParameterFormula;
use App\Models\ParameterHistory;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index(Version $version)
    {
        // Retrieve all parameters where version_id is null or $version->id
        $allParameters = Parameter::where('version_id', $version->id)->get();

        // Filter the parameters based on calculation_type_id
        $market = $allParameters->where('calculation_type_id', 1);
        $preparation = $allParameters->where('calculation_type_id', 2);
        $implementation = $allParameters->where('calculation_type_id', 3);
        $evaluation = $allParameters->where('calculation_type_id', 4);
        $infrastructure = $allParameters->where('calculation_type_id', 5);
        $courseFeeStudentEnrollment = $allParameters->where('calculation_type_id', 6);
        $courseFee = $allParameters->where('calculation_type_id', 7);
        $certificateFeeStudentEnrollment = $allParameters->where('calculation_type_id', 8);
        $certificateFee = $allParameters->where('calculation_type_id', 9);

        // dd($courseFeeStudentEnrollment);

        $marketRes = $version->calculations->where('calculation_type_id', 1)->first();
        $preparationRes = $version->calculations->where('calculation_type_id', 2)->first();
        $implementationRes = $version->calculations->where('calculation_type_id', 3)->first();
        $evaluationRes = $version->calculations->where('calculation_type_id', 4)->first();
        $infrastructureRes = $version->calculations->where('calculation_type_id', 5)->first();
        $courseEnrollmentRes = $version->calculations->where('calculation_type_id', 6)->first();
        $certificateEnrollmentRes = $version->calculations->where('calculation_type_id', 8)->first();

        $courseFeeRes = $version->calculations
            ->where('calculation_type_id', 7)
            ->where('status', true)
            ->first();

        if (!$courseFeeRes) {
            $courseFeeRes = $version->calculations
                ->where('calculation_type_id', 7)
                ->first();
        }

        $certificateFeeRes = $version->calculations
            ->where('calculation_type_id', 9)
            ->where('status', true)
            ->first();

        if (!$certificateFeeRes) {
            $certificateFeeRes = $version->calculations
                ->where('calculation_type_id', 9)
                ->first();
        }

        $histories = History::with('version')->where('user_id', Auth::id())->get()->sortByDesc('created_at');
        $courses = Course::all();
        $details = HistoryDetail::all();
        $parameter_histories = ParameterHistory::all();
        $calculation_types = CalculationType::all();
        $children = ChildParameterHistory::all();
        $formula = Formula::where('version_id', $version->id)->get();
        $formulaArr = [];
        $i = 0;

        // Extract tokens from formulas
        foreach ($formula as $f) {
            $pattern = '/\b(\w+)\b/';
            preg_match_all($pattern, $f->formula, $matches);

            // Check if matches[1] is set before using it
            $tokenDictionary = isset($matches[1]) ? $matches[1] : [];

            // Append $tokenDictionary elements to $formulaArr
            $formulaArr[] = $tokenDictionary;
        }

        $formulaName = [];

        // Replace token IDs with parameter names
        foreach ($formulaArr as $tokenArray) {
            $formulaName[] = array_map(function ($token) use ($allParameters) {
                $parameter = $allParameters->firstWhere('id', $token);
                return $parameter ? $parameter->parameter_name : $token;
            }, $tokenArray);
        }

        // Output the result
        // dd($formulaName);

        return view('calculations.detail', compact('version', 'market', 'preparation', 'implementation', 'evaluation', 'infrastructure', 'courseFeeStudentEnrollment', 'courseFee', 'certificateFeeStudentEnrollment', 'certificateFee', 'marketRes', 'preparationRes', 'implementationRes', 'evaluationRes', 'infrastructureRes', 'courseEnrollmentRes', 'courseFeeRes', 'certificateEnrollmentRes', 'certificateFeeRes', 'histories', 'courses', 'details', 'parameter_histories', 'calculation_types', 'children', 'formula'));
    }
}
