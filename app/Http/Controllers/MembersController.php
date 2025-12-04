<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Members;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DriversByCompanyExport;


class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = User::where('type', 0)->get();
        return view('admin.members', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Members $members)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Members $members)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Members::where('user_id', $id);
        $user->delete();

        $driver = Driver::where('company_id', $id);
        $driver->delete();

        $member = User::findOrFail($id);
        $member->delete();

        alert()->success('success!', 'member deleted successfully.');
        return redirect()->back()
            ->with('success', 'member deleted successfully');
    }

    public function ActiveMember(string $id)
    {
        $member = User::findOrFail($id);
        $member->status = "Active";
        $member->update();

        $existingUser = Members::where('user_id', $id)->first();

        if ($existingUser === null) {
            // member does not exist, proceed with insertion
            $company = new Members();
            $company->name = $member->name;
            $company->status = "activated";
            $company->user_id  = $member->id;
            $company->save();

            alert()->success('success!', 'Member activated successfully.');
            return redirect()->back()
                ->with('success', 'member successfully active');
        } else {
            // User already exists, handle the case accordingly
            // For example, return an error message or redirect back with a message
            alert()->warning('Warning!', 'Member already activated.');

            return redirect()->back()
                ->with('success', 'member successfully active');
        }
    }
    public function InActiveMember(string $id)
    {
        $member = User::findOrFail($id);
        $member->status = "Inactive";
        $member->update();

        alert()->success('success!', 'Member Deactivated successfully.');

        return redirect()->back()
            ->with('success', 'member InActive successfully');
    }

    public function memberReport()
    {
        $members = Members::select('name')->withCount('drivers')->distinct()->get();
        return view('admin.membersReport', compact('members'));
    }

    public function DriverApproved($name, $status)
    {
        $drivers = Driver::where('company', $name)
            ->where('status', $status)->get();
        $memberOf = $name;
        $statusOf = $status;
        return view('admin.driversByMember', compact('drivers', 'name', 'status', 'memberOf', 'statusOf'));
    }
    public function exportDriver($name, $status)
    {

        return Excel::download(new DriversByCompanyExport($name, $status), 'drivers.xlsx');
    }
}
