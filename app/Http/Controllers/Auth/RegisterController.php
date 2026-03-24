<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function create()
    {
        return Inertia::render('auth/Register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'role' => ['required','integer','min:2','max:3'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:3','confirmed'],
        ]);

        // Create the user and log them in
        $user = User::create([
            'name' => $request->name,
            // 'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // TODO: Handle role assignment based on the selected role in the registration form
        
        // Send verification email if email verification is implemented
        event(new Registered($user));

        //login the user
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
