<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CalculationType;
use App\Models\ChildParameterHistory;
use App\Models\Course;
use App\Models\Formula;
use App\Models\History;
use App\Models\HistoryDetail;
use App\Models\ParameterFormula;
use App\Models\ParameterHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index() {
        $histories = History::with('version')->where('user_id', Auth::id())->get();
        $courses = Course::all();
        $details = HistoryDetail::all();
        $parameter_histories = ParameterHistory::all();
        $calculation_types = CalculationType::all();
        $children = ChildParameterHistory::all();

        return response()->json(compact('histories', 'courses', 'details', 'parameter_histories', 'calculation_types', 'children'));
    }

    public function deleteHistory($historyId) {
        HistoryDetail::where('history_id', $historyId)->delete();
        ParameterHistory::where('history_id', $historyId)->delete();
        History::where('id', $historyId)->delete();

        return response()->json(['message' => 'History Deleted Successfully']);
    }
}
