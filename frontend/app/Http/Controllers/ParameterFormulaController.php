<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterFormulaController extends Controller
{
    public function getFromParameter(Request $request)
    {
        $parameterId = $request->input('id');

        $param = Parameter::find($parameterId);

        return response()->json($param ? $param->parameterFormula()->get() : null);
    }
}
