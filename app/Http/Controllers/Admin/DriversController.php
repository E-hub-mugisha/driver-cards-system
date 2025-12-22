<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriversController extends Controller
{
    public function index()
    {
        $drivers = Driver::withTrashed()->with('company')->paginate(15);
        $companies = Company::all();
        return view('admin.drivers.index', compact('drivers', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required',
            'ID_number' => 'required|unique:drivers',
            'driver_license' => 'required|unique:drivers',
            'phone' => 'required|unique:drivers',
            'company_id' => 'nullable|exists:companies,id',
            'photo' => 'nullable|image|max:2048',
            'contract' => 'nullable|file|max:5120',
        ]);

        $data = $request->all();

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

        Driver::create($data);

        return back()->with('success', 'Driver added successfully.');
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'names' => 'required',
            'ID_number' => 'required|unique:drivers,ID_number,' . $driver->id,
            'driver_license' => 'required|unique:drivers,driver_license,' . $driver->id,
            'phone' => 'required|unique:drivers,phone,' . $driver->id,
            'company_id' => 'nullable|exists:companies,id',
            'photo' => 'nullable|image|max:2048',
            'contract' => 'nullable|file|max:5120',
        ]);

        $data = $request->all();

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

        $driver->update($data);

        return back()->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return back()->with('success', 'Driver soft deleted.');
    }

    public function restore($id)
    {
        $driver = Driver::withTrashed()->findOrFail($id);
        $driver->restore();
        return back()->with('success', 'Driver restored successfully.');
    }
}
