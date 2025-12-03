<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::where('company_id', Auth::user()->id)->get();
        return view('drivers.index', compact('drivers'));
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
        $request->validate([
            'names' => 'required',
            'ID_number' => 'required',
            'driver_license' => 'required',
            'phone' => 'required',
            'rssb' => 'required',
            'contract_type' =>  'required',
            'insurance' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            // 'contract' => 'required|mimes:pdf|max:10240',
        ]);

        $driver = new Driver();
        $member =  Members::where('user_id', Auth::user()->id)->first();
        $driver->company_id = Auth::user()->id;
        $driver->names =  $request->input('names');
        $driver->ID_number =   $request->input('ID_number');
        $driver->driver_license = $request->input('driver_license');
        $driver->phone = $request->input('phone');
        $driver->rssb = $request->input('rssb');
        $driver->company = Auth::user()->name;
        $driver->contract_type = $request->input('contract_type');
        $driver->insurance = $request->input('insurance');
        $driver->status = "pending";

        if ($photo = $request->file('photo')) {
            $destinationPath = 'photo/';
            $profilePhoto = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profilePhoto);
            $driver['photo'] = "$profilePhoto";
        }

        if ($contract = $request->file('contract')) {
            $destinationPath = 'contract/';
            $profileContract = date('YmdHis') . "." . $contract->getClientOriginalExtension();
            $contract->move($destinationPath, $profileContract);
            $driver['contract'] = "$profileContract";
        }

        $driver->save();
        alert()->success('success!','Driver created successfully.');
        return redirect()->route('driver.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Driver::where("id", $id)->firstOrFail();

        // Check user is owner of this driver or admin
        if (Auth::user()->id != $driver->company_id) {
            abort(403);
        }

        return view('drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $driver = Driver::where("id", $id)->firstOrFail();

        // Check user is owner of this driver or admin
        if (Auth::user()->id != $driver->company_id) {
            abort(403);
        }

        return view('drivers.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $driver=Driver::findOrFail($id);
        // Validate request
        $request->validate([
            'names' => 'required',
            'ID_number' => 'required',
            'driver_license' => 'required',
            'phone' => 'required',
            'rssb' => 'required',
            'company' => 'required',
            'contract_type' =>  'required',
            'insurance' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            // 'contract' => 'required|mimes:pdf|max:10240',
        ]);

        $driver->company_id = Auth::user()->id;
        $driver->names =  $request->input('names');
        $driver->ID_number =   $request->input('ID_number');
        $driver->driver_license = $request->input('driver_license');
        $driver->phone = $request->input('phone');
        $driver->rssb = $request->input('rssb');
        $driver->company = $request->input('company');
        $driver->contract_type = $request->input('contract_type');
        $driver->insurance = $request->input('insurance');

        if ($photo = $request->file('photo')) {
            $destinationPath = 'photo/';
            $profilePhoto = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profilePhoto);
            $driver['photo'] = "$profilePhoto";
        }

        if ($contract = $request->file('contract')) {
            $destinationPath = 'contract/';
            $profileContract = date('YmdHis') . "." . $contract->getClientOriginalExtension();
            $contract->move($destinationPath, $profileContract);
            $driver['contract'] = "$profileContract";
        }

        $driver->update();
        alert()->success('success!','Driver updated successfully.');
        return redirect()->route('driver.index')
            ->with('success', 'driver Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver=Driver::findOrFail($id);
        $driver->delete();
        alert()->success('success!','Driver deleted successfully.');
        return redirect()->route( 'driver.index')
                        ->with('success','driver deleted successfully');
    }
}
