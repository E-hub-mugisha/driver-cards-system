<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyStaff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CompanyStaffController extends Controller
{
    public function index(Company $company)
    {
        $staff = $company->staff()->latest()->paginate(20);

        return view('admin.companies.staff.index', compact('company', 'staff'));
    }

    public function store(Request $request, Company $company)
    {
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
    public function update(Request $request, CompanyStaff $staff)
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
    public function destroy(CompanyStaff $staff)
    {
        $staff->user()->delete();  // soft delete linked user
        $staff->delete();          // soft delete staff
        return back()->with('success', 'Staff removed (soft deleted).');
    }
    public function resetPassword(CompanyStaff $staff)
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
    public function restore($id)
    {
        $staff = CompanyStaff::withTrashed()->findOrFail($id);
        $staff->restore();
        return back()->with('success', 'Staff restored successfully.');
    }
}
