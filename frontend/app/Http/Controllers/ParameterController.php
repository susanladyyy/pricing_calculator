<?php

namespace App\Http\Controllers;

use App\Models\CalculationType;
use App\Models\ChildParameter;
use App\Models\Formula;
use App\Models\Parameter;
use App\Models\ParameterType;
use App\Models\Version;
use App\Rules\ValidFormula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParameterController extends Controller
{
    public function updateParameterView($parameterId)
    {
        $parameter = Parameter::where('id', $parameterId)->first();
        $parameter_type = ParameterType::all();
        $children = ChildParameter::where('parameter_id', $parameterId)->get();

        return view('user.update-parameter', compact('parameter', 'parameter_type', 'children'));
    }

    public function updateParameter(Request $request, $parameterId)
    {
        $parameter = Parameter::where('id', $parameterId)->first();

        $validated = $request->validate([
            'parameterName' => 'required',
            'parameterContent' => 'numeric',
        ]);

        if ($parameter->parameter_type_id == 1) {
            if ($request->parameterContent != null) {
                $parameter->update([
                    'parameter_name' => $validated['parameterName'],
                    'parameter_content' => $request->parameterContent,
                ]);
            } else {
                $parameter->update([
                    'parameter_name' => $validated['parameterName'],
                    'parameter_content' => 0,
                ]);
            }
        } else {
            $parameter->update([
                'parameter_name' => $validated['parameterName'],
            ]);
        }

        return redirect()->intended('/detail/' . $parameter->version_id);
    }

    public function deleteSubParentParameter($parentParameterId)
    {
        Parameter::where('id', $parentParameterId)->delete();

        return response()->json(['message' => 'Parameter deleted successfully']);
    }

    public function deleteSubParameter($childParameterId)
    {
        ChildParameter::where('id', $childParameterId)->delete();

        return response()->json(['message' => 'Parameter deleted successfully']);
    }

    public function addNewParameterView($versionId, $calculationTypeId)
    {
        $parameters = Parameter::with('courseVersion')->with('calculationType')->with('parameterType')->where('version_id', $versionId)->where('calculation_type_id', $calculationTypeId)->get();
        $calculation_type = CalculationType::where('id', $calculationTypeId)->first();
        $parameter_type = ParameterType::all();
        $children = ChildParameter::all();
        $formula = Formula::where('calculation_type_id', $calculationTypeId)->where('version_id', $versionId)->first();

        $split = explode(" ", $formula->formula);
        $str_formula = "";

        for ($i = 0; $i < count($split); $i++) {
            if (is_numeric($split[$i])) {
                $name = Parameter::where('id', $split[$i])->first()->parameter_name;
                if ($i == count($split) - 1) {
                    $str_formula .= "(" . $name . ")";
                } else {
                    $str_formula .= "(" . $name . ")" . " ";
                }
            } else {
                $str_formula .= $split[$i] . " ";
            }
        }

        return view('user.insert-parameter', compact('parameters', 'calculation_type', 'parameter_type', 'children', 'str_formula', 'versionId'));
    }

    public function addNewSubParameterView($parameterId, $calculationTypeId, $versionId)
    {
        $parameter = Parameter::where('id', $parameterId)->with('parameterType')->first();

        $calculation_type = CalculationType::where('id', $calculationTypeId)->first();
        $parameter_type = ParameterType::all();
        $children = ChildParameter::where('parameter_id', $parameterId)->get();

        return view('user.insert-sub', compact('parameter', 'calculation_type', 'parameter_type', 'children', 'versionId'));
    }

    public function addNewSubParameter(Request $request, $parameterId, $calculationTypeId, $versionId)
    {
        $parent_id = $request->parameterId;

        $childrenArray = $request->input('childrenArray');
        $childrenArrayNoSpace = $request->input('childrenArrayNoSpace');

        $array = json_decode($childrenArray);
        $array_no_space = json_decode($childrenArrayNoSpace);

        for ($i = 0; $i < count($array_no_space); $i++) {
            if ($request->input('cost' . $array_no_space[$i]) == null && $request->input('number' . $array_no_space[$i]) == null) {
                ChildParameter::create([
                    'parameter_id' => $parent_id,
                    'user_id' => Auth::id(),
                    'parameter_name' => $array[$i],
                    'parameter_cost' => 0,
                    'parameter_number' => 0,
                ]);
            } else if ($request->input('cost' . $array_no_space[$i]) == null) {
                ChildParameter::create([
                    'parameter_id' => $parent_id,
                    'user_id' => Auth::id(),
                    'parameter_name' => $array[$i],
                    'parameter_cost' => 0,
                    'parameter_number' => $request->input('number' . $array_no_space[$i]),
                ]);
            } else if ($request->input('number' . $array_no_space[$i]) == null) {
                ChildParameter::create([
                    'parameter_id' => $parent_id,
                    'user_id' => Auth::id(),
                    'parameter_name' => $array[$i],
                    'parameter_cost' => $request->input('cost' . $array_no_space[$i]),
                    'parameter_number' => 0,
                ]);
            } else {
                ChildParameter::create([
                    'parameter_id' => $parent_id,
                    'user_id' => Auth::id(),
                    'parameter_name' => $array[$i],
                    'parameter_cost' => $request->input('cost' . $array_no_space[$i]),
                    'parameter_number' => $request->input('number' . $array_no_space[$i]),
                ]);
            }
        }

        return redirect()->intended('/detail/' . $versionId);
    }

    public function addNewParameter(Request $request, $versionId, $calculationTypeId)
    {
        $validated = $request->validate([
            'parameterId' => 'required|max:10|unique:parameters,id',
            'parameterName' => 'required',
            'parameterType' => 'required',
        ]);

        if ($validated['parameterType'] == 1) {
            Parameter::create([
                'id' => strtoupper($validated['parameterId']),
                'version_id' => $versionId,
                'parameter_type_id' => $validated['parameterType'],
                'calculation_type_id' => $calculationTypeId,
                'user_id' => Auth::id(),
                'parameter_name' => $validated['parameterName'],
                'parameter_content' => 0
            ]);
        } else {
            $parent = Parameter::create([
                'id' => strtoupper($validated['parameterId']),
                'version_id' => $versionId,
                'parameter_type_id' => $validated['parameterType'],
                'calculation_type_id' => $calculationTypeId,
                'user_id' => Auth::id(),
                'parameter_name' => $validated['parameterName'],
                'parameter_content' => 0
            ]);

            $childrenArray = $request->input('childrenArray');
            $childrenArrayNoSpace = $request->input('childrenArrayNoSpace');

            $array = json_decode($childrenArray);
            $array_no_space = json_decode($childrenArrayNoSpace);

            for ($i = 0; $i < count($array_no_space); $i++) {
                if ($request->input('cost' . $array_no_space[$i]) == null && $request->input('number' . $array_no_space[$i]) == null) {
                    ChildParameter::create([
                        'parameter_id' => $parent->id,
                        'user_id' => Auth::id(),
                        'parameter_name' => $array[$i],
                        'parameter_cost' => 0,
                        'parameter_number' => 0,
                    ]);
                } else if ($request->input('cost' . $array_no_space[$i]) == null) {
                    ChildParameter::create([
                        'parameter_id' => $parent->id,
                        'user_id' => Auth::id(),
                        'parameter_name' => $array[$i],
                        'parameter_cost' => 0,
                        'parameter_number' => $request->input('number' . $array_no_space[$i]),
                    ]);
                } else if ($request->input('number' . $array_no_space[$i]) == null) {
                    ChildParameter::create([
                        'parameter_id' => $parent->id,
                        'user_id' => Auth::id(),
                        'parameter_name' => $array[$i],
                        'parameter_cost' => $request->input('cost' . $array_no_space[$i]),
                        'parameter_number' => 0,
                    ]);
                } else {
                    ChildParameter::create([
                        'parameter_id' => $parent->id,
                        'user_id' => Auth::id(),
                        'parameter_name' => $array[$i],
                        'parameter_cost' => $request->input('cost' . $array_no_space[$i]),
                        'parameter_number' => $request->input('number' . $array_no_space[$i]),
                    ]);
                }
            }
        }

        return redirect()->intended('/detail/' . $versionId);
    }

    public function updateParameterContent(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');

        $sanitize_res = str_replace("Rp. ", "", $value);
        $sanitize_res = str_replace(".", "", $sanitize_res);
        $sanitize_res = intval($sanitize_res);

        if (strpos($key, "cost") === 0) {
            $param = ChildParameter::find(substr($key, strlen("cost_")));

            if ($param) {
                $param->parameter_cost = $sanitize_res;
                $param->save();
            }
        } else if (strpos($key, "total") === 0) {
            $param = ChildParameter::find(substr($key, strlen("total_")));

            if ($param) {
                $param->parameter_number = $sanitize_res;
                $param->save();
            }
        } else if (strpos($key, "mulmed") === 0) {
            $version = Version::find(substr($key, strlen("mulmed_")));

            if ($version) {
                $version->multimedia_number = $sanitize_res;
                $version->save();
            }
        } else {
            $param = Parameter::find($key);

            if ($param) {
                $param->parameter_content = $sanitize_res;
                $param->save();
            }
        }

        return response()->json(['message' => 'Parameter updated successfully']);
    }

    public function getCalculationData(Request $request)
    {
        $variableTokens = $request->input('variableTokens');

        $version = Version::find($request->input('version'));

        $data = [];

        foreach ($variableTokens as $token) {
            if ($token == 'ROUNDUP') {
                $data[$token] = 'ROUNDUP';
            } else if ($token == "CM") {
                $data[$token] = $version->course->first()->multimedia_number;
            } else if ($token == "CS") {
                $data[$token] = $version->course->first()->session_number;
            } else if (substr($token, 0, 1) == "R") {
                $calculationType = preg_replace("/[^0-9]/", "", $token);

                $data[$token] = $version->calculations->where('calculation_type_id', $calculationType)->first()->result ?? 0;
            } else if (ctype_digit($token)) {
                $data[$token] = intval($token);
            } else {
                $parameter = Parameter::find($token);

                $data[$token] = $parameter ? $parameter->parameter_content : 0;
            }
        }

        return response()->json($data);
    }
}
