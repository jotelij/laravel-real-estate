<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProfileController extends Controller
{
    //
    public function edit(Request $request)
    {
        $user = Auth::user();
        $data = [
            'user' => $request->user(),
            'status' => session('status'),
        ];
        
        if($user->is_agent()) {
            return Inertia::render('agent/Profile', $data);
        } else if($user->is_admin()) {
            return Inertia::render('admin/Profile', $data);
        } else {
            return Inertia::render('customer/Profile', $data);
        }
    }  

    public function updateInfo(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => [
                'required',  'string', 'email', 'max:255', 
                Rule::unique(User::class)->ignore($request->user()->id)
            ],
        ]);

        $request->user()->fill($data);

        // check if email is changed
        if($request->user()->isDirty('email')) {
            // if email is changed, mark email as unverified
            $request->user()->email_verified_at = null;

            // send email verification notification
             $request->user()->sendEmailVerificationNotification();
        }

        $request->user()->save();
        return back()->with('status', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($data['current_password'], $request->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $request->user()->password = Hash::make($data['password']);
        $request->user()->save();

        return back()->with('status', 'Password updated successfully.');
    }

    public function deleteAccount(Request $request)
    {
        $data = $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Account deleted successfully.');  
    }
}
