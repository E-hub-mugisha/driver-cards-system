<?php

use App\Http\Controllers\Admin\AdminBehaviorController;
use App\Http\Controllers\Admin\AdminDriverController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyDriversController;
use App\Http\Controllers\Admin\CompanyStaffController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriversController;
use App\Http\Controllers\Admin\IncidentController;
use App\Http\Controllers\Admin\PayrollProcessingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Company\CompanyDashboardController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembersController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Company\CompanyDriverController;
use App\Http\Controllers\Company\CompanyDriverIncidentController;
use App\Http\Controllers\Company\CompanyDriverReportController;
use App\Http\Controllers\Company\CompanyProfileController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/run-migrations', function () {

    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Migrations and seeders executed successfully.',
        'output' => Artisan::output(),
    ]);
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

    Route::get('/admin/company/payroll/settings', [CompanyController::class, 'indexPayroll'])
        ->name('admin.payroll.settings.index');
    // Store new payroll setting
    Route::post('/admin/payroll/settings', [CompanyController::class, 'storePayroll'])
        ->name('admin.payroll.settings.store');

    // Update existing payroll setting
    Route::put('/admin/company/payroll/settings/{payrollSetting}', [CompanyController::class, 'updatePayroll'])
        ->name('admin.payroll.settings.update');

    Route::prefix('admin/drivers')->name('admin.drivers.')->group(function () {
        Route::get('/', [DriversController::class, 'index'])->name('index');
        Route::post('/store', [DriversController::class, 'store'])->name('store');
        Route::post('/{driver}/update', [DriversController::class, 'update'])->name('update');
        Route::delete('/{driver}/destroy', [DriversController::class, 'destroy'])->name('destroy');
        Route::post('/{driver}/restore', [DriversController::class, 'restore'])->name('restore');
        Route::get('/{driver}', [DriversController::class, 'show'])->name('show');
        Route::post('/{driver}/approve', [DriversController::class, 'approve'])
            ->name('approve');

        Route::post('{driver}/incidents', [IncidentController::class, 'store'])
            ->name('incidents.store');

        Route::post('incidents/{incident}/approve', [IncidentController::class, 'approve'])
            ->name('incidents.approve');

        Route::post('incidents/{incident}/reject', [IncidentController::class, 'reject'])
            ->name('incidents.reject');
    });

    Route::prefix('admin/companies/{company}')->group(function () {
        Route::get('/drivers', [CompanyDriversController::class, 'companyDrivers'])->name('admin.company.drivers.index');
        Route::post('/drivers', [CompanyDriversController::class, 'storeForCompany'])->name('admin.company.drivers.store');
        Route::post('/drivers/{driver}', [CompanyDriversController::class, 'updateForCompany'])->name('admin.company.drivers.update');
        Route::delete('/drivers/{driver}', [CompanyDriversController::class, 'softDeleteForCompany'])->name('admin.company.drivers.delete');
        Route::post('/drivers/{driver}/restore', [CompanyDriversController::class, 'restoreForCompany'])->name('admin.company.drivers.restore');
    });

    Route::post('/admin/settings', [DashboardController::class, 'index'])
        ->name('admin.settings.index');

    Route::get('/notifications', [DashboardController::class, 'notification'])->name('notifications.index');
    Route::get('/notifications/mark-all', [DashboardController::class, 'markAllRead'])->name('notifications.markAllRead');

    // View single driver behavior list
    Route::get('driver/{driver}/behaviors', [AdminBehaviorController::class, 'driverBehaviors'])
        ->name('admin.driver.behaviors');

    // Download single driver report
    Route::get('driver/{driver}/behaviors/download', [AdminBehaviorController::class, 'downloadDriverBehaviors'])
        ->name('admin.driver.behaviors.download');

    // Send single driver report by email
    Route::post('driver/{driver}/behaviors/send-email', [AdminBehaviorController::class, 'sendDriverBehaviorReport'])
        ->name('admin.driver.behaviors.sendEmail');
});

Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('behaviors', [AdminBehaviorController::class, 'index'])->name('behaviors.index');
    Route::post('behaviors', [AdminBehaviorController::class, 'store'])->name('behaviors.store');
    Route::put('behaviors/{behavior}', [AdminBehaviorController::class, 'update'])->name('behaviors.update');
    Route::delete('behaviors/{behavior}', [AdminBehaviorController::class, 'destroy'])->name('behaviors.destroy');
    Route::get('/admin/behaviors/{behavior}/drivers', [AdminBehaviorController::class, 'driverBehavior'])->name('behaviors.drivers');

    Route::get('/company-behavior', [AdminBehaviorController::class, 'indexDrivers'])->name('company.behavior.page');
    Route::get('/company-behavior/drivers/{company}', [AdminBehaviorController::class, 'getDrivers']);
});

Route::prefix('reports')->middleware(['auth'])->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/admin/reports/export/pdf', [ReportController::class, 'exportPdf'])
        ->name('admin.reports.export.pdf');

    Route::get('/admin/reports/export/excel', [ReportController::class, 'exportExcel'])
        ->name('admin.reports.export.excel');

    Route::get('/drivers', [ReportController::class, 'driverReports'])->name('reports.drivers');
    Route::get('/behaviors', [ReportController::class, 'behaviorReports'])->name('reports.behaviors');
    Route::get('/incidents', [ReportController::class, 'incidentReports'])->name('reports.incidents');
});

Route::prefix('admin/payroll')->name('admin.payroll.')->group(function () {

    Route::get('/', [PayrollProcessingController::class, 'index'])->name('index');

    Route::get('preview', [PayrollProcessingController::class, 'preview'])->name('preview');
    Route::post('process', [PayrollProcessingController::class, 'process'])->name('process');
    Route::get('review', [PayrollProcessingController::class, 'review'])->name('review');

    Route::post('{payroll}/approve', [PayrollProcessingController::class, 'approve'])->name('approve');
    Route::get('driver/{detail}/download', [PayrollProcessingController::class, 'downloadDriverPayslip'])->name('download.driver');
});


/*------------------------------------------
--------------------------------------------
All Company (Staff) Routes
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('profile', [CompanyProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [CompanyProfileController::class, 'update'])->name('profile.update');

        // Drivers (company-only)
        Route::prefix('drivers')->name('drivers.')->group(function () {
            Route::get('/', [CompanyDriverController::class, 'index'])
                ->name('index');

            Route::post('/', [CompanyDriverController::class, 'store'])
                ->name('store');

            Route::get('{driver}', [CompanyDriverController::class, 'show'])
                ->name('show');

            Route::put('{driver}', [CompanyDriverController::class, 'update'])
                ->name('update');

            Route::delete('{driver}', [CompanyDriverController::class, 'destroy'])
                ->name('destroy');

            Route::post('{driver}/restore', [CompanyDriverController::class, 'restore'])
                ->name('restore');
        });

        // Staff Management (company-only)

        Route::get('/staff', [CompanyProfileController::class, 'indexStaff'])
            ->name('staff.index');

        Route::post('/staff', [CompanyProfileController::class, 'storeStaff'])
            ->name('staff.store');
        Route::put('/staff/{staff}/update', [CompanyProfileController::class, 'updateStaff'])
            ->name('staff.update');

        Route::delete('/staff/{staff}', [CompanyProfileController::class, 'destroyStaff'])
            ->name('staff.destroy');

        Route::post('/staff/{staff}/reset-password', [CompanyProfileController::class, 'resetPasswordStaff'])
            ->name('staff.reset-password');

        // Driver Behaviors (company view)
        Route::get('/drivers/{driver}/behaviors', [CompanyDriverController::class, 'indexBehavior'])
            ->name('drivers.behaviors.index');

        Route::post('/{driver}/behaviors', [CompanyDriverController::class, 'storeBehavior'])->name('drivers.behaviors.store');

        // View single driver behavior list
        Route::get('driver/{driver}/behaviors', [CompanyDriverReportController::class, 'driverBehaviors'])
            ->name('driver.behaviors');

        // Download single driver report
        Route::get('driver/{driver}/behaviors/download', [CompanyDriverReportController::class, 'downloadDriverBehaviors'])
            ->name('driver.behaviors.download');

        // Send single driver report by email
        Route::post('driver/{driver}/behaviors/send-email', [CompanyDriverReportController::class, 'sendDriverBehaviorReport'])
            ->name('driver.behaviors.sendEmail');

        Route::post('{driver}/incidents', [CompanyDriverIncidentController::class, 'store'])
            ->name('incidents.store');

        Route::post('incidents/{incident}/approve', [CompanyDriverIncidentController::class, 'approve'])
            ->name('incidents.approve');

        Route::post('incidents/{incident}/reject', [CompanyDriverIncidentController::class, 'reject'])
            ->name('incidents.reject');

        Route::get('/drivers/{driver}/incidents', [CompanyDriverController::class, 'indexIncident'])
            ->name('drivers.incidents.index');

        // Reports (company scoped)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/drivers', [CompanyDriverReportController::class, 'driverReports'])
                ->name('drivers');

            Route::get('/behaviors', [CompanyDriverReportController::class, 'behaviorReports'])
                ->name('behaviors');

            Route::get('/incidents', [CompanyDriverReportController::class, 'incidentReports'])
                ->name('incidents');

            Route::get('/', [CompanyDashboardController::class, 'reportCompany'])
                ->name('index');

            Route::get('/export/pdf/{type}', [CompanyDriverReportController::class, 'exportPdf'])
                ->name('export.pdf');
            Route::get('/export/excel/{type}', [CompanyDriverReportController::class, 'exportExcel'])
                ->name('export.excel');
        });

        // Payroll (company view only)
        Route::prefix('payroll')->name('payroll.')->group(function () {
            Route::get('/', [CompanyDashboardController::class, 'payrollCompany'])
                ->name('index');

            Route::post('settings', [CompanyDashboardController::class, 'storePayroll'])
                ->name('settings.store');

            // Update existing payroll setting
            Route::put('settings/{payrollSetting}', [CompanyDashboardController::class, 'updatePayroll'])
                ->name('settings.update');

            Route::post(
                '/generate',
                [CompanyDashboardController::class, 'generate']
            )->name('generate');

            Route::get('preview', [CompanyDashboardController::class, 'previewPayroll'])
                ->name('preview');

            Route::post('process', [CompanyDashboardController::class, 'processPayroll'])->name('process');
            Route::get('review', [CompanyDashboardController::class, 'reviewPayroll'])->name('review');

            Route::post('{payroll}/approve', [CompanyDashboardController::class, 'approvePayroll'])->name('approve');
            Route::get('driver/{detail}/download', [CompanyDashboardController::class, 'downloadDriverPayslip'])->name('download.driver');

            Route::post('/send-otp/{payroll}', [CompanyDashboardController::class, 'sendOtp'])->name('sendOtp');
            Route::post('/delete/{payroll}', [CompanyDashboardController::class, 'deletePayroll'])->name('delete');
        });

        // Notifications
        Route::get('/notifications', [DashboardController::class, 'notification'])
            ->name('notifications.index');

        Route::get('/notifications/mark-all', [DashboardController::class, 'markAllRead'])
            ->name('notifications.markAllRead');
    });

// Show form to request password reset
Route::get('password/reset', [PasswordResetController::class, 'request'])
    ->name('password.request');

// Handle sending reset email
Route::post('password/email', [PasswordResetController::class, 'email'])
    ->name('password.email');

// Show form to reset password (via token)
Route::get('password/reset/{token}', [PasswordResetController::class, 'reset'])
    ->name('password.reset');

// Handle password update
Route::post('password/reset', [PasswordResetController::class, 'update'])
    ->name('password.update');
