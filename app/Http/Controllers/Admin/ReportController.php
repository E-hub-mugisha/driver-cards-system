<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverBehavior;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'totalDrivers' => Driver::count(),
            'avgScore' => Driver::avg('performance_score'),

            'highRiskDrivers' => Driver::where('risk_level', 'high')->count(),

            'totalIncidents' => Incident::count(),
            'openIncidents' => Incident::where('status', 'open')->count(),
            'closedIncidents' => Incident::where('status', 'closed')->count(),

            'monthlyIncidents' => Incident::select(
                DB::raw('COUNT(id) as total'),
                DB::raw('MONTHNAME(created_at) as month')
            )->groupBy('month')->get(),

            'behaviorStats' => DriverBehavior::select(
                DB::raw('COUNT(id) as total'),
                'severity'
            )->groupBy('severity')->get(),
        ]);
    }
}
