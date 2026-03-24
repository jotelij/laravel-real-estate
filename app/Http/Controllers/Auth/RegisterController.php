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
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // TODO: Handle role assignment based on the selected role in the registration form
        
        // Send verification email if email verification is implemented
        // TODO: add the registered event back after email verification is implemented
        // event(new Registered($user));

        //login the user
        Auth::login($user);

        // TODO: remove this block after email verification is implemented
        if(Auth::user()->is_agent()) {
            return redirect()->route('agent.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }

        
        return redirect()->route('dashboard');
    }
}
