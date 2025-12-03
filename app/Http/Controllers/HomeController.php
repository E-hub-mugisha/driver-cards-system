<?php

namespace App\Http\Controllers;

use App\Exports\DriversExport;
use App\Models\Driver;
use App\Models\Members;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function dashboard(): View
    {
        return view('adminHome');
    }
    
    public function index(): View
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome(): View
    {
        return view('managerHome');
    }

    public function adminHome()
    {
        $drivers = Driver::all();
        $companies = Members::all();
        return view('admin.index', compact('drivers','companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Members::all();
        return view('admin.create', compact('companies'));
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
            'company' => 'required',
            'contract_type' =>  'required',
            'insurance' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            // 'contract' => 'required|mimes:pdf|max:10240',
        ]);

        $users = User::where('name', $request->input('company'))->first();
        $company_id = $users->id;

        $driver = new Driver();
        
        $driver->company_id = $company_id;
        $driver->names =  $request->input('names');
        $driver->ID_number =   $request->input('ID_number');
        $driver->driver_license = $request->input('driver_license');
        $driver->phone = $request->input('phone');
        $driver->rssb = $request->input('rssb');
        $driver->company = $request->input('company');
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

        alert()->success('success!','Driver Saved successfully.');

        return redirect()->route('admin.index')
            ->with('success', 'driver created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Driver::where("id", $id)->firstOrFail();

        // Check user is owner of this driver or admin
        // if (Auth::user()->id != $driver->company_id) {
        //     abort(403);
        // }

        return view('admin.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $driver = Driver::where("id", $id)->firstOrFail();

        // Check user is owner of this driver or admin
        // if (Auth::user()->id != $driver->company_id) {
        //     abort(403);
        // }

        return view('admin.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $driver = Driver::findOrFail($id);
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

        $users = User::where('name', $request->input('company'))->first();
        $company_id = $users->id;
        $driver->company_id = $company_id;
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

        alert()->success('success!','Driver update successfully.');

        return redirect()->route('admin.index')
            ->with('success', 'driver Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        alert()->success('success!','Driver deleted successfully.');

        return redirect()->route('admin.index')
            ->with('success', 'driver deleted successfully');
    }

    public function approval(string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = "approved";
        $driver->update();

        alert()->success('success!','Driver approved successfully.');

        return redirect()->route('admin.index')
            ->with('success', 'driver approved successfully');
    }
    public function pending(string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = "Pending";
        $driver->update();

        alert()->success('success!','Driver set pending successfully.');

        return redirect()->route('admin.index')
            ->with('success', 'driver successfully pending');
    }
    public function decline(string $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = "declined";
        $driver->update();

        alert()->success('success!','Driver Decline successfully.');

        return redirect()->route('admin.index')
            ->with('success', 'driver declined successfully');
    }

    public function export() 
    {
        return Excel::download(new DriversExport, 'drivers.xlsx');
    }

    public function exportDriver() 
    {
        return Excel::download(new DriversExport, 'driverByMember.xlsx');
    }

    public function DownloadContract($id)
    {
        $driver = Driver::findOrFail($id);
        $myFile = public_path("contract/$driver->contract");
        $headers = ['Content-Type: application/pdf'];
        $newName = "$driver->names".'.pdf';
      
        return response()->download($myFile, $newName, $headers);
    }

    public function DownloadPhoto($id)
    {
        $driver = Driver::findOrFail($id);
        $myPhoto = public_path("photo/$driver->photo");
        $newName = "$driver->names".'.png';
      
        return response()->download($myPhoto, $newName);
    }

    public function systemUsers()
    {
        // Get all users and roles and permissions.
        $users = User::all();
        return view('admin.system-users', compact('users'));
    }
    public function adminUsers($id)
    {
        $user = User::findOrFail($id);
        $user->type = 1;
        $user->update();

        alert()->success('success!','user set to admin successfully.');

        return redirect()->back();
    }
    public function destroyUsers(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        alert()->success('success!','user deleted successfully.');

        return redirect()->back()
            ->with('success', 'user deleted successfully');
    }
}
