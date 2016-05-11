<?php

namespace App\Http\Controllers\Admin;

use App\DistanceLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DistanceLogsController extends Controller
{
    public function index()
    {
        $logs = DistanceLog::all();

        return view('admin.distance_logs.index', compact('logs'));
    }

    public function delete(DistanceLog $log)
    {
        $log->delete();

        return redirect()->back()->with('success', 'Лог успешно удалён.');
    }
}
