<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PayrollSetting;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:companies,email',
            'status' => 'required'
        ]);

        Company::create($request->only('name', 'email', 'phone', 'address', 'status'));

        return back()->with('success', 'Company Created Successfully');
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:companies,email,$company->id",
            'status' => 'required'
        ]);

        $company->update($request->only('name', 'email', 'phone', 'address', 'status'));

        return back()->with('success', 'Company Updated Successfully');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Company Deleted Successfully');
    }

    public function storePayroll(Request $request)
    {
        $request->validate([
            'company_id'  => 'required|exists:companies,id',
            'salary_type' => 'required|in:fixed,per_trip',
            'base_salary' => 'required|numeric',
            'trip_rate'   => 'nullable|numeric',
            'tax_rate'    => 'required|numeric',
            'rssb_rate'   => 'required|numeric',
        ]);

        PayrollSetting::create($request->all());

        return back()->with('success', 'Payroll settings saved successfully.');
    }

    public function updatePayroll(Request $request, PayrollSetting $payrollSetting)
    {
        $request->validate([
            'salary_type' => 'required|in:fixed,per_trip',
            'base_salary' => 'required|numeric',
            'trip_rate'   => 'nullable|numeric',
            'tax_rate'    => 'required|numeric',
            'rssb_rate'   => 'required|numeric',
        ]);

        $payrollSetting->update($request->all());

        return back()->with('success', 'Payroll settings updated successfully.');
    }
}
