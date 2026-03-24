<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return Inertia::render('auth/VerifyEmail', [
            'status' => session('status'),
        ]);
    }

    public function handler(EmailVerificationRequest $request)
    {
        $request->fulfill();

        // TODO: Redirect to the intended page after email verification, or to the dashboard if no intended page is set
        return redirect()->route('dashboard');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Verification link sent!');
    }
}
