<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Incident;
use Illuminate\Http\Request;

class CompanyDriverIncidentController extends Controller
{
    public function store(Request $request, Driver $driver)
    {
        $request->validate([
            'type' => 'required',
            'severity' => 'required',
            'incident_date' => 'required|date',
            'description' => 'nullable',
            'location' => 'nullable',
            'evidence' => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ]);

        $impactValues = [
            'low' => 5,
            'medium' => 15,
            'high' => 25,
            'critical' => 40,
        ];

        $impact = $impactValues[$request->severity];

        $filePath = null;
        if ($request->hasFile('evidence')) {
            $filePath = $request->file('evidence')->store('incidents', 'public');
        }

        $incident = $driver->incidents()->create([
            'type' => $request->type,
            'severity' => $request->severity,
            'incident_date' => $request->incident_date,
            'location' => $request->location,
            'description' => $request->description,
            'evidence' => $filePath,
            'reported_by' => auth()->id(),
            'impact_score' => -$impact,
            'approval_status' => 'pending'
        ]);

        // ⛔ Impact performance score
        $driver->performance_score = ($driver->performance_score ?? 0) - $impact;
        $driver->save();

        return back()->with('success', 'Incident recorded & performance updated.');
    }

    public function approve(Incident $incident)
    {
        $incident->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->user()->name,
            'approved_at' => now()
        ]);

        // Apply impact to driver score
        $driver = $incident->driver;
        $driver->performance_score = ($driver->performance_score ?? 0) + ($incident->impact_score * -1);
        $driver->save();

        return back()->with('success', 'Incident approved & performance updated');
    }

    public function reject(Request $request, Incident $incident)
    {
        $request->validate([
            'rejection_reason' => 'required'
        ]);

        $incident->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('warning', 'Incident rejected');
    }
}
