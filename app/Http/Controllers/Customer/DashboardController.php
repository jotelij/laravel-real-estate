<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
    
        $user->load('favourites')->loadCount('enquiries_sent', 'viewings', 'favourites');

        $enquiries = $user->enquiries_sent()
            ->with('property', 'messages',  'agent.agent_profile')
            ->latest()
            ->limit(4)
            ->get();
        
        $favourite_properties = $user->favourites()
            ->with('images')
            ->limit(6)
            ->get();
        
        $viewings = $request->user()->viewings()
            ->with('property', 'agent.agent_profile')
            ->latest()
            ->limit(3)
            ->get();

        return Inertia::render('customer/Dashboard', [
            'user' => $user,
            'recent_enquiries' => $enquiries,
            'favourite_properties' => $favourite_properties,
            'recent_viewings' => $viewings,
        ]);
    }
}
