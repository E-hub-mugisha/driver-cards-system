<?php

use App\Http\Controllers\Admin\AdminBehaviorController;
use App\Http\Controllers\Admin\AdminDriverController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyDriversController;
use App\Http\Controllers\Admin\CompanyStaffController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriversController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Company\CompanyDashboardController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembersController;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
});


Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/driver', [DriverController::class, 'index'])->name('driver.index');
    Route::post('/driver/add', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('/driver/{id}', [DriverController::class, "show"])->name('drivers.show');
    Route::get('/driver/edit/{id}', [DriverController::class, "edit"])->name('drivers.edit');
    Route::put('/driver/update/{id}', [DriverController::class, "update"])->name('drivers.update');
    Route::delete('/driver/delete/{id}', [DriverController::class, "destroy"])->name('drivers.destroy');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [DashboardController::class, 'index'])->name('admin.home');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}/status', [UserController::class, 'updateStatus'])
        ->name('admin.users.updateStatus');
    Route::post('/admin/users/{user}/reset-password', [UserController::class, 'resetPassword'])
        ->name('admin.users.reset-password');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');
    Route::put('/admin/users/admin/{id}', [HomeController::class, 'adminUsers'])->name('users.admin');
    Route::delete('/admin/users/delete/{id}', [HomeController::class, 'destroyUsers'])->name('users.delete');
    Route::get('drivers-export', [HomeController::class, 'export'])->name('drivers.export');
    Route::get('drivers/export/{name}/{status}', [MembersController::class, 'exportDriver'])->name('drivers.exportByCompany');
    Route::get('driversByMember-export/{name}/{status}', [HomeController::class, 'exportDriver'])->name('driversByMember.export');
    Route::get('download-contract/{id}', [HomeController::class, 'DownloadContract'])->name('contracts.download');
    Route::get('download-photo/{id}', [HomeController::class, 'DownloadPhoto'])->name('photo.download');
    Route::get('/members', [MembersController::class, 'index'])->name('member.index');
    Route::put('/member/active/{id}', [MembersController::class, 'ActiveMember'])->name('member.active');
    Route::put('/member/inactive/{id}', [MembersController::class, 'InActiveMember'])->name('member.inactive');
    Route::get('/member/report', [MembersController::class, 'memberReport'])->name('member.report');
    Route::get('/member/driver/{name}/{status}', [MembersController::class, 'DriverApproved'])->name('approved.driver');
    Route::get('/member/driver/pending', [MembersController::class, 'DriverPending'])->name('pending.driver');
    Route::get('/member/driver/approved', [MembersController::class, 'DriverDeclined'])->name('declined.driver');
    Route::delete('/admin/member/delete/{id}', [MembersController::class, "destroy"])->name('member.delete');

    Route::post('/admin/drivers/{driver}/behaviors', [AdminDriverController::class, 'storeBehavior'])->name('admin.drivers.behaviors.store');
    Route::get('/admin/drivers/{driver}/behaviors', [AdminDriverController::class, 'indexBehavior'])->name('admin.drivers.behaviors.index');

    Route::get('/admin/companies', [CompanyController::class, 'index'])->name('admin.companies.index');
    Route::post('/admin/companies', [CompanyController::class, 'store'])->name('admin.companies.store');
    Route::post('/admin/companies/{company}', [CompanyController::class, 'update'])->name('admin.companies.update');
    Route::post('/admin/companies/{company}/delete', [CompanyController::class, 'destroy'])->name('admin.companies.destroy');

    Route::get('/admin/companies/{company}/staff', [CompanyStaffController::class, 'index'])
        ->name('admin.company.staff.index');

    Route::post('/admin/companies/{company}/staff', [CompanyStaffController::class, 'store'])
        ->name('admin.company.staff.store');
    Route::put('/admin/company-staff/{staff}/update', [CompanyStaffController::class, 'update'])
        ->name('admin.company.staff.update');

    Route::delete('/admin/company-staff/{staff}', [CompanyStaffController::class, 'destroy'])
        ->name('admin.company.staff.destroy');

    Route::post('/admin/company-staff/{staff}/reset-password', [CompanyStaffController::class, 'resetPassword'])
        ->name('admin.company.staff.reset-password');

    Route::prefix('admin/drivers')->name('admin.drivers.')->group(function () {
        Route::get('/', [DriversController::class, 'index'])->name('index');
        Route::post('/store', [DriversController::class, 'store'])->name('store');
        Route::post('/{driver}/update', [DriversController::class, 'update'])->name('update');
        Route::delete('/{driver}/destroy', [DriversController::class, 'destroy'])->name('destroy');
        Route::post('/{driver}/restore', [DriversController::class, 'restore'])->name('restore');
        Route::get('/{driver}', [DriversController::class, 'show'])->name('show');
        Route::post('/{driver}/approve', [DriversController::class, 'approve'])
            ->name('approve');
    });

    Route::prefix('admin/companies/{company}')->group(function () {
        Route::get('/drivers', [CompanyDriversController::class, 'companyDrivers'])->name('admin.company.drivers.index');
        Route::post('/drivers', [CompanyDriversController::class, 'storeForCompany'])->name('admin.company.drivers.store');
        Route::post('/drivers/{driver}', [CompanyDriversController::class, 'updateForCompany'])->name('admin.company.drivers.update');
        Route::delete('/drivers/{driver}', [CompanyDriversController::class, 'softDeleteForCompany'])->name('admin.company.drivers.delete');
        Route::post('/drivers/{driver}/restore', [CompanyDriversController::class, 'restoreForCompany'])->name('admin.company.drivers.restore');
    });
});

Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('behaviors', [AdminBehaviorController::class, 'index'])->name('behaviors.index');
    Route::post('behaviors', [AdminBehaviorController::class, 'store'])->name('behaviors.store');
    Route::put('behaviors/{behavior}', [AdminBehaviorController::class, 'update'])->name('behaviors.update');
    Route::delete('behaviors/{behavior}', [AdminBehaviorController::class, 'destroy'])->name('behaviors.destroy');
    Route::get('/admin/behaviors/{behavior}/drivers', [AdminBehaviorController::class, 'driverBehavior'])->name('behaviors.drivers');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])->group(function () {

    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
});
