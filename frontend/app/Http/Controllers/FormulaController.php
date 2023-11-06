<?php

namespace App\Http\Controllers;

use App\Models\CalculationType;
use App\Models\ChildParameter;
use App\Models\Formula;
use App\Models\Parameter;
use App\Models\Version;
use App\Rules\ValidFormula;
use Illuminate\Http\Request;

class FormulaController extends Controller
{
    public function index(Version $version, $calculationTypeId)
    {
        $parameters = Parameter::where('version_id', $version->id)->get();
        $calculation_type = CalculationType::where('id', $calculationTypeId)->first();
        $formula = Formula::where('calculation_type_id', $calculation_type->id)->where('version_id', $version->id)->first();
        $children = ChildParameter::all();

        return view('user.insert-formula', compact('parameters', 'calculation_type', 'formula', 'children', 'version', 'calculationTypeId'));
    }

    public function editFormula(Request $request, $versionId, $calculationTypeId)
    {
        $validated = $request->validate([
            'formulaInput' => ['required', new ValidFormula],
        ]);
        $version = Version::find($versionId);

        $formulaWithoutSymbols = preg_replace('/[^\w\s]/', '', $validated['formulaInput']);
        $variableTokens = preg_split('/\s+/', $formulaWithoutSymbols, -1, PREG_SPLIT_NO_EMPTY);

        $substitutedFormula = $validated['formulaInput'];
        foreach ($variableTokens as $token) {
            if ($token == 'ROUNDUP') {
                $data[$token] = 'ROUNDUP';
            } else if ($token == "CM") {
                $data[$token] = "Number of Multimedia";
            } else if ($token == "CS") {
                $data[$token] = "Number of Session";
            } else if (substr($token, 0, 1) == "R") {
                $calculationType = preg_replace("/[^0-9]/", "", $token);

                $data[$token] = $version->calculations->where('calculation_type_id', $calculationType)->first()->result ?? 0;
            } else if (ctype_digit($token)) {
                $data[$token] = intval($token);
            } else {
                $parameter = Parameter::find($token);

                $data[$token] = $parameter ? $parameter->parameter_name : "";
            }

            $substitutedFormula = preg_replace('/' . $token . '/', $data[$token], $substitutedFormula);
        }

        // dd("Substituted Formula: " . $substitutedFormula);

        Formula::where('calculation_type_id', $calculationTypeId)->where('version_id', $versionId)->first()->update([
            'formula' => $validated['formulaInput'],
            'formula_name' => $substitutedFormula,
        ]);

        return redirect('/detail/' . $versionId);
    }
}
