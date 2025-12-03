<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

    Route::get('/admin/home', [HomeController::class, 'dashboard'])->name('admin.home');
    Route::get('/admin/driver', [HomeController::class, 'adminHome'])->name('admin.index');
    Route::get('/admin/driver/create', [HomeController::class, 'create'])->name('admin.create');
    Route::get('/admin/users', [HomeController::class, 'systemUsers'])->name('admin.users');
    Route::put('/admin/users/admin/{id}', [HomeController::class, 'adminUsers'])->name('users.admin');
    Route::delete('/admin/users/delete/{id}', [HomeController::class, 'destroyUsers'])->name('users.delete');
    Route::post('/admin/driver/add', [HomeController::class, 'store'])->name('admin.store');
    Route::get('/admin/driver/{id}', [HomeController::class, "show"])->name('admin.show');
    Route::get('/admin/driver/edit/{id}', [HomeController::class, "edit"])->name('admin.edit');
    Route::put('/admin/driver/update/{id}', [HomeController::class, "update"])->name('admin.update');
    Route::put('/admin/driver/approval/{id}', [HomeController::class, "approval"])->name('admin.approval');
    Route::put('/admin/driver/pending/{id}', [HomeController::class, "pending"])->name('admin.pending');
    Route::put('/admin/driver/decline/{id}', [HomeController::class, "decline"])->name('admin.decline');
    Route::delete('/admin/driver/delete/{id}', [HomeController::class, "destroy"])->name('admin.destroy');
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
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])->group(function () {

    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
});
