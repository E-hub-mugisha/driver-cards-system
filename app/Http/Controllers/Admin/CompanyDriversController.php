<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Driver;
use Illuminate\Http\Request;

class CompanyDriversController extends Controller
{
    public function companyDrivers(Company $company)
    {
        $drivers = Driver::withTrashed()
            ->where('company_id', $company->id)
            ->get();

        return view('admin.companies.drivers.index', compact('company', 'drivers'));
    }

    public function storeForCompany(Request $request, Company $company)
    {
        $data = $request->validate([
            'names' => 'required',
            'ID_number' => 'required',
            'driver_license' => 'required',
            'phone' => 'required',
            'rssb' => 'nullable',
            'contract_type' => 'required',
            'Insurance' => 'required',
            'photo' => 'nullable|image|max:2048',
            'contract' => 'nullable|mimes:pdf,docx|max:4096',
            'status' => 'required'
        ]);

        $data['company_id'] = $company->id;

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

    public function updateForCompany(Request $request, Company $company, Driver $driver)
    {
        abort_if($driver->company_id != $company->id, 403);

        $data = $request->validate([
            'names' => 'required',
            'ID_number' => 'required',
            'driver_license' => 'required',
            'phone' => 'required',
            'rssb' => 'nullable',
            'contract_type' => 'required',
            'Insurance' => 'required',
            'status' => 'required'
        ]);

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

    public function softDeleteForCompany(Company $company, Driver $driver)
    {
        abort_if($driver->company_id != $company->id, 403);

        $driver->delete();
        return back()->with('success', 'Driver soft deleted.');
    }

    public function restoreForCompany(Company $company, $driver)
    {
        $driver = Driver::onlyTrashed()
            ->where('company_id', $company->id)
            ->where('id', $driver)
            ->firstOrFail();

        $driver->restore();
        return back()->with('success', 'Driver restored successfully.');
    }
}
