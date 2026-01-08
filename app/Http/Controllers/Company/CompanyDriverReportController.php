<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Mail\DriverBehaviorReportMail;
use App\Models\BehaviorType;
use App\Models\Driver;
use App\Models\DriverBehavior;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CompanyDriverReportController extends Controller
{
    protected function company()
    {
        return auth()->user()->staff->company;
    }

    public function behaviorReports()
    {
        // Get the company of the authenticated staff
        $company = auth()->user()->staff->company;

        // Get drivers of this company who have behaviors, with counts and eager loading
        $drivers = Driver::where('company_id', $company->id)
            ->whereHas('behaviors') // only drivers with behaviors
            ->with([
                'behaviors' => function ($query) {
                    $query->with(['behaviorType.behaviorCategory', 'reporter']);
                }
            ])
            ->withCount('behaviors') // adds behaviors_count
            ->get();

        $totalDrivers = $drivers->count();

        return view('company.behaviors.drivers', compact('company', 'drivers', 'totalDrivers'));
    }

    public function incidentReports()
    {
        // Get the company of the authenticated staff
        $company = auth()->user()->staff->company;

        // Get drivers of this company who have incidents, with counts and eager loading
        $drivers = Driver::where('company_id', $company->id)
            ->whereHas('incidents') // only drivers with incidents
            ->withCount('incidents') // adds incidents_count
            ->get();

        $totalDrivers = $drivers->count();

        return view('company.incident.drivers', compact('company', 'drivers', 'totalDrivers'));
    }

    // Show single driver behavior list
    public function driverBehaviors(\App\Models\Driver $driver)
    {
        $driver->load(['behaviors.behaviorType.behaviorCategory', 'behaviors.reporter']);
        return view('company.drivers.behaviors', compact('driver'));
    }

    // Download single driver report
    public function downloadDriverBehaviors(\App\Models\Driver $driver)
    {
        $driver->load(['behaviors.behaviorType.behaviorCategory', 'behaviors.reporter']);

        $company = auth()->user()->staff->company; // Get the scoped company

        $pdf = Pdf::loadView('company.drivers.behaviors_pdf', compact('driver', 'company'));
        return $pdf->download("DriverBehaviorReport-{$driver->names}.pdf");
    }

    public function sendDriverBehaviorReport(Request $request, \App\Models\Driver $driver)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $driver->load(['behaviors.behaviorType.behaviorCategory', 'behaviors.reporter']);
        $company = $driver->company ?? auth()->user()->staff->company;

        $pdf = PDF::loadView('company.drivers.behaviors_pdf', compact('driver', 'company'));

        Mail::to($request->email)->send(new DriverBehaviorReportMail($driver, $pdf));

        return back()->with('success', 'Report sent successfully to ' . $request->email);
    }
}
