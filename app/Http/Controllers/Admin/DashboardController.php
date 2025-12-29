<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::latest()->take(5)->get();
        $companies = Company::latest()->take(5)->get();
        $drivers = Driver::with('company')
            ->latest()
            ->take(5)
            ->get();
        $TotalDrivers = Driver::count();

        $DriversMonth = Driver::where('created_at', '>=', now()->subDays(30))->count();
        $DriversWeek  = Driver::where('created_at', '>=', now()->subDays(7))->count();

        // Optional growth %
        $PrevMonth = Driver::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $MonthChange = $PrevMonth ? (($DriversMonth - $PrevMonth) / $PrevMonth) * 100 : 0;

        $PrevWeek = Driver::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $WeekChange = $PrevWeek ? (($DriversWeek - $PrevWeek) / $PrevWeek) * 100 : 0;
        $activeDrivers = Driver::where('status', 'active')->count();
        $suspendedDrivers = Driver::where('status', 'suspended')->count();
        $pendingDrivers = Driver::where('status', 'pending')->count();

        $companiesLast7 = Company::where('created_at', '>=', now()->subDays(7))->count();
        $companiesPrev7 = Company::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();

        $avgCompaniesPerDay = $companiesLast7 / 7;

        $companyChange = $companiesPrev7
            ? (($companiesLast7 - $companiesPrev7) / $companiesPrev7) * 100
            : 0;
        return view('admin.dashboard.index', compact(
            'users',
            'companies',
            'drivers',
            'TotalDrivers',
            'DriversMonth',
            'DriversWeek',
            'MonthChange',
            'WeekChange',
            'activeDrivers',
            'suspendedDrivers',
            'pendingDrivers',
            'avgCompaniesPerDay',
            'companyChange'
        ));
    }
}
