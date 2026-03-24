<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthenticateController extends Controller
{
     public function create()
    {
        return Inertia::render('auth/Login');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($data, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            $rrt = match ($user->role) {
                UserRole::AGENT => route('agent.dashboard'),
                UserRole::CUSTOMER => route('customer.dashboard'),
                default => route('dashboard'),
            };
            
            // TODO: Redirect to intended page after login
            return redirect()->intended($rrt);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
