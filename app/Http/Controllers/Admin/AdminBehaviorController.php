<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BehaviorCategory;
use App\Models\BehaviorType;
use App\Models\Company;
use App\Models\Driver;
use App\Models\DriverBehavior;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBehaviorController extends Controller
{
    public function index()
    {
        $categories = BehaviorCategory::with('behaviorTypes.driverBehaviors')->get();
        return view('admin.behaviors.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_id'         => 'required|exists:drivers,id',
            'behavior_type_id'  => 'required|exists:behavior_types,id',
            'severity'          => 'required|in:low,medium,high',
            'behavior_date'     => 'required|date',
            'description'       => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            $behaviorType = BehaviorType::findOrFail($request->behavior_type_id);
            $driver = Driver::findOrFail($request->driver_id);
            $behaviorDate = Carbon::parse($request->behavior_date);

            // Severity weights
            $weights = [
                'low'    => 5,
                'medium' => 10,
                'high'   => 20,
            ];

            $baseScore = $behaviorType->default_score ?? 0;
            $severityScore = $weights[$request->severity];

            // Final score with positive/negative effect
            $finalScore = $baseScore + $severityScore;
            if ($behaviorType->category === 'negative') {
                $finalScore = -abs($finalScore);
            }

            // Save behavior
            DriverBehavior::create([
                'driver_id'         => $driver->id,
                'behavior_type_id'  => $behaviorType->id,
                'category'          => $behaviorType->category,
                'severity'          => $request->severity,
                'score'             => $finalScore,
                'behavior_date'     => $behaviorDate->format('Y-m-d'),
                'recorded_month'    => $behaviorDate->startOfMonth()->format('Y-m-d'),
                'description'       => $request->description,
                'reported_by'       => auth()->id(),
            ]);

            // Update driver performance score
            $driver->performance_score = max(0, $driver->performance_score + $finalScore);
            $driver->save();
        });

        return back()->with('success', 'Behavior recorded & score updated successfully.');
    }

    public function update(Request $request, BehaviorType $behavior)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:positive,negative',
            'severity' => 'required|in:low,medium,high',
            'default_score' => 'required|integer',
        ]);


        $behavior->update($request->all());
        return back()->with('success', 'Behavior updated successfully');
    }


    public function destroy(BehaviorType $behavior)
    {
        $behavior->delete();
        return back()->with('success', 'Behavior deleted');
    }

    public function driverBehavior(BehaviorType $behavior)
    {
        $drivers = $behavior->driverBehaviors()
            ->with('driver')
            ->latest()
            ->paginate(20);

        return view('admin.behaviors.drivers', compact('behavior', 'drivers'));
    }

    public function indexDrivers()
    {
        $companies = Company::select('id', 'name')->get();

        $selectedCompany = null;
        $drivers = [];

        if (request()->has('company_id') && request('company_id') != '') {
            $selectedCompany = Company::find(request()->company_id);

            if ($selectedCompany) {
                $drivers = $selectedCompany->drivers()
                    ->with('behaviors')     // Load behaviors
                    ->withCount('behaviors') // Count behaviors
                    ->get();
            }
        }

        return view('admin.behaviors.company-drivers', compact('companies', 'selectedCompany', 'drivers'));
    }

    public function getDrivers(Company $company)
    {
        $drivers = $company->drivers()
            ->with('behaviors')   // ensure relation exists
            ->get();

        return response()->json($drivers);
    }
}
