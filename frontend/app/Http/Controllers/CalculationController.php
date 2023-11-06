<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use App\Models\ChildParameter;
use App\Models\ChildParameterHistory;
use App\Models\History;
use App\Models\HistoryDetail;
use App\Models\Parameter;
use App\Models\ParameterHistory;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculationController extends Controller
{
    public function saveToHistory($versionId)
    {
        $history = History::create([
            'user_id' => Auth::id(),
            'version_id' => $versionId,
        ]);

        // loop add parameter history
        $parameter_per_version = Parameter::where('version_id', $versionId)->get();
        $calculation_per_version = Calculation::where('version_id', $versionId)->get();

        for ($i = 0; $i < count($parameter_per_version); $i++) {
            $parent = ParameterHistory::create([
                'version_id' => $parameter_per_version[$i]->version_id,
                'history_id' => $history->id,
                'parameter_type_id' => $parameter_per_version[$i]->parameter_type_id,
                'calculation_type_id' => $parameter_per_version[$i]->calculation_type_id,
                'parameter_id' => $parameter_per_version[$i]->id,
                'parameter_name' => $parameter_per_version[$i]->parameter_name,
                'parameter_content' => $parameter_per_version[$i]->parameter_content
            ]);

            // loop add child parameter history
            if ($parent->parameter_type_id == 2) {
                $child = ChildParameter::where('parameter_id', $parameter_per_version[$i]->id)->get();

                for ($j = 0; $j < count($child); $j++) {
                    ChildParameterHistory::create([
                        'parameter_history_id' => $parent->id,
                        'parameter_name' => $child[$j]->parameter_name,
                        'parameter_cost' => $child[$j]->parameter_cost,
                        'parameter_number' => $child[$j]->parameter_number
                    ]);
                }
            }
        }

        for ($i = 0; $i < count($calculation_per_version); $i++) {
            // loop add history detail
            HistoryDetail::create([
                'history_id' => $history->id,
                'version_id' => $calculation_per_version[$i]->version_id,
                'calculation_type_id' => $calculation_per_version[$i]->calculation_type_id,
                'result' => $calculation_per_version[$i]->result
            ]);
        }

        return response()->json(['message' => 'Calculation saved successfully']);
    }

    public function saveCalculation(Request $request, Version $version)
    {
        $data = $request->all();
        $keys = array_keys($data);

        foreach ($keys as $key) {
            $sanitize_res = str_replace("Rp. ", "", $data[$key]);
            $sanitize_res = str_replace(".", "", $sanitize_res);
            $sanitize_res = intval($sanitize_res);

            if (substr($key, -6) === "result") {
                $calc_type = $data['calculation-type'];
                $status = $data['status'] ?? false;

                $calc = $version->calculations->where('calculation_type_id', $calc_type)->first();

                if ($calc) {
                    $calc->result = $sanitize_res;
                    $calc->status = $status;
                } else {
                    $calc = new Calculation([
                        'version_id' => $version->id,
                        'calculation_type_id' => $calc_type,
                        'result' => $sanitize_res,
                        'status' => $status,
                    ]);
                }

                $calc->save();
                break;
            }
        }
        return back();
    }
}
