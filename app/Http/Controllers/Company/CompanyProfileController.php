<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyStaff;
use App\Models\DriverBehavior;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CompanyProfileController extends Controller
{
    protected function company()
    {
        return auth()->user()->staff->company;
    }

    public function index()
    {
        $company = auth()->user()->staff->company;
        // KPI Data
        $totalDrivers = $company->drivers()->count();
        $totalStaff   = $company->staff()->count();
        $totalIncidents = $company->drivers()->withCount('incidents')->get()->sum('incidents_count');

        $monthlyPayrolls = $company->payrolls() // Note the parentheses
            ->where('month', '>=', now()->subMonths(6))
            ->join('payroll_details', 'payroll_details.payroll_id', '=', 'payrolls.id')
            ->selectRaw('MONTH(month) as month_number, MONTHNAME(month) as month_name, SUM(net_salary) as total_net')
            ->groupBy('month_number', 'month_name')
            ->orderBy('month_number')
            ->get();

        $months = $monthlyPayrolls->pluck('month_name');
        $netSalaries = $monthlyPayrolls->pluck('total_net');

        // Monthly Penalties
        $monthlyPenalties = $company->drivers()
            ->with(['incidents' => function ($q) {
                $q->where('incident_date', '>=', now()->subMonths(6));
            }])
            ->get()
            ->flatMap->incidents
            ->groupBy(function ($incident) {
                return \Carbon\Carbon::parse($incident->incident_date)->format('M Y');
            })
            ->map(fn($group) => $group->sum('impact_score'));

        // Monthly driver & behavior trends (last 6 months)
        $monthlyDrivers = $company->drivers()
            ->withCount(['behaviors as behaviors_count' => function ($q) {
                $q->where('created_at', '>=', now()->subMonths(6));
            }])
            ->get();

        $monthlyStats = collect([]);
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M Y');

            // Drivers added in that month
            $driversCount = $company->drivers()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Behaviors reported in that month
            $behaviorsCount = DriverBehavior::whereHas('driver', fn($q) => $q->where('company_id', $company->id))
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $monthlyStats->push([
                'month' => $monthName,
                'drivers' => $driversCount,
                'behaviors' => $behaviorsCount
            ]);
        }

        $months = $monthlyStats->pluck('month');
        $driversData = $monthlyStats->pluck('drivers');
        $behaviorsData = $monthlyStats->pluck('behaviors');

        return view('company.profile.index', compact(
            'company',
            'totalDrivers',
            'totalStaff',
            'totalIncidents',
            'months',
            'netSalaries',
            'monthlyPenalties',
            'driversData',
            'behaviorsData'
        ));
    }

    public function update(Request $request)
    {
        $company = auth()->user()->staff->company;

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'company_logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/company', $filename);
            $data['logo'] = $filename;
        }

        $company->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function indexStaff()
    {
        $company = auth()->user()->staff->company;
        $staff = $company->staff()->latest()->paginate(20);

        return view('company.profile.staff.index', compact('company', 'staff'));
    }

    public function storeStaff(Request $request)
    {

        $company = auth()->user()->staff->company;

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required'
        ]);

        // 1️⃣ Create User Account
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make('password123'),
            'type'      => 2, // Manager/Staff
            'status'    => 'active'
        ]);

        // 2️⃣ Link to Staff Table
        CompanyStaff::create([
            'company_id' => $company->id,
            'user_id'    => $user->id,
            'role'       => $request->role,
            'name'      => $request->name,
            'email'     => $request->email,
        ]);

        // After creating user & staff
        Mail::to($request->email)->send(new \App\Mail\StaffPasswordReset($user, 'password123'));
        return back()->with('success', 'Staff added successfully.');
    }
    public function updateStaff(Request $request, CompanyStaff $staff)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $staff->user_id,
            'role'  => 'required',
            'status' => 'required'
        ]);

        // Update Staff info
        $staff->update([
            'role'   => $request->role,
            'status' => $request->status
        ]);

        // Update linked User info
        $staff->user()->update([
            'name'  => $request->name,
            'email' => $request->email
        ]);

        return back()->with('success', 'Staff updated successfully.');
    }
    public function destroyStaff(CompanyStaff $staff)
    {
        $staff->user()->delete();  // soft delete linked user
        $staff->delete();          // soft delete staff
        return back()->with('success', 'Staff removed (soft deleted).');
    }
    public function resetPasswordStaff(CompanyStaff $staff)
    {
        $newPassword = 'Password123'; // You may generate random password here

        $staff->user()->update([
            'password' => Hash::make($newPassword)
        ]);

        // Optional: send email with new password
        Mail::to($staff->user->email)->send(new \App\Mail\StaffPasswordReset($staff->user, $newPassword));

        return back()->with('success', 'Password has been reset and emailed to staff.');
    }

    // Restore soft-deleted staff
    public function restoreStaff($id)
    {
        $staff = CompanyStaff::withTrashed()->findOrFail($id);
        $staff->restore();
        return back()->with('success', 'Staff restored successfully.');
    }
}
