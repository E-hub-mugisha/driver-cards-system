<?php

namespace App\Observers;

use App\Models\CompanyStaff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyStaffObserver
{
    /**
     * Handle the CompanyStaff "created" event.
     */
    public function created(CompanyStaff $staff)
    {
        // Create linked user automatically (without request)
        $user = User::create([
            'name' => $staff->name ?? 'Default Name',
            'email'=> $staff->email ?? 'user@example.com',
            'password'=> Hash::make('password123'),
            'type'=> 2,
            'status'=> 'active'
        ]);

        $staff->update([
            'user_id' => $user->id
        ]);
    }

    /**
     * Handle the CompanyStaff "updated" event.
     */
    public function updated(CompanyStaff $companyStaff): void
    {
        //
    }

    /**
     * Handle the CompanyStaff "deleted" event.
     */
    public function deleted(CompanyStaff $companyStaff): void
    {
        //
    }

    /**
     * Handle the CompanyStaff "restored" event.
     */
    public function restored(CompanyStaff $companyStaff): void
    {
        //
    }

    /**
     * Handle the CompanyStaff "force deleted" event.
     */
    public function forceDeleted(CompanyStaff $companyStaff): void
    {
        //
    }
}
