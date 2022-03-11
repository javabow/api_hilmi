<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'report' => ['required'],
            'report_name' => ['required']
        ]);

        $add_report = new Report;
        $add_report->report = $request->report;
        $add_report->report_name = $request->report_name;

        if ($add_report->save()) {
            return response()->json(array('success' => true, 'last_insert_id' => $add_report->id), 200);
        } else {
            return response()->json(array('success' => false), 401);
        }
    }
}
