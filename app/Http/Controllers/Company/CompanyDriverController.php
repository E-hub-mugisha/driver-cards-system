<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\BehaviorCategory;
use App\Models\BehaviorType;
use App\Models\Driver;
use App\Models\DriverBehavior;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyDriverController extends Controller
{
    protected function company()
    {
        return auth()->user()->staff->company;
    }

    public function index()
    {
        $company = $this->company();

        $drivers = Driver::withTrashed()
            ->where('company_id', $company->id)
            ->latest()
            ->get();

        return view('company.drivers.index', compact('company', 'drivers'));
    }

    public function store(Request $request)
    {
        $company = $this->company();

        $data = $request->validate([
            'names'           => 'required|string',
            'ID_number'       => 'required|string',
            'driver_license'  => 'required|string',
            'phone'           => 'required|string',
            'rssb'            => 'nullable|string',
            'contract_type'   => 'required|string',
            'Insurance'       => 'required|string',
            'photo'           => 'nullable|image|max:2048',
            'contract'        => 'nullable|mimes:pdf,docx|max:4096',
            'status'          => 'required'
        ]);

        $data['company_id'] = $company->id;

        if ($photo = $request->file('photo')) {
            $data['photo'] = $photo->store('drivers/photos', 'public');
        }

        if ($contract = $request->file('contract')) {
            $data['contract'] = $contract->store('drivers/contracts', 'public');
        }

        Driver::create($data);

        return back()->with('success', 'Driver added successfully.');
    }

    public function update(Request $request, Driver $driver)
    {
        $company = $this->company();

        abort_if($driver->company_id !== $company->id, 403);

        $data = $request->validate([
            'names'           => 'required|string',
            'ID_number'       => 'required|string',
            'driver_license'  => 'required|string',
            'phone'           => 'required|string',
            'rssb'            => 'nullable|string',
            'contract_type'   => 'required|string',
            'Insurance'       => 'required|string',
            'status'          => 'required'
        ]);

        if ($photo = $request->file('photo')) {
            $data['photo'] = $photo->store('drivers/photos', 'public');
        }

        if ($contract = $request->file('contract')) {
            $data['contract'] = $contract->store('drivers/contracts', 'public');
        }

        $driver->update($data);

        return back()->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $company = $this->company();

        abort_if($driver->company_id !== $company->id, 403);

        $driver->delete();

        return back()->with('success', 'Driver soft deleted.');
    }

    public function restore($id)
    {
        $company = $this->company();

        $driver = Driver::onlyTrashed()
            ->where('company_id', $company->id)
            ->where('id', $id)
            ->firstOrFail();

        $driver->restore();

        return back()->with('success', 'Driver restored successfully.');
    }

    public function show(Driver $driver)
    {
        $driver->load(['company', 'behaviors']); // make sure relationship exists
        $categories = BehaviorCategory::with('behaviorTypes.driverBehaviors')->get();
        $company = $this->company();
        return view('company.drivers.show', compact('driver', 'categories','company'));
    }

    public function storeBehavior(Request $request)
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

    public function indexIncident(Driver $driver)
    {
        $company = $this->company();

        abort_if($driver->company_id !== $company->id, 403);

        $driver->load('incidents');

        return view('company.incident.index', compact('company', 'driver'));
    }
}
