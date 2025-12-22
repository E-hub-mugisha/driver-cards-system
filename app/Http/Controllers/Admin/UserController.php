<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Get all users and roles and permissions.
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'type' => 'required|in:0,1,2,3',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,suspended,inactive'
        ]);

        $user->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'User status updated successfully');
    }
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed'
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
            'password_changed_at' => now(),
        ]);

        return back()->with('success', 'Password reset successfully');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return back()->with('error', "You cannot delete your own account.");
        }

        $user->delete();

        return back()->with('success', 'User soft deleted successfully.');
    }
}
