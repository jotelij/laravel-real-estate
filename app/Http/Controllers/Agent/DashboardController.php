<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Viewing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $user->load('enquiries_received.property', 'properties')
        ->loadCount('enquiries_received', 'agent_viewings', 'properties');
        
        $viewings = Viewing::where('agent_id', $user->id)
        ->with(['property', 'buyer'])
        ->orderBy('scheduled_at', 'asc')
        ->limit(3)
        ->get();

        $enquiries = $user->enquiries_received()
            ->with('property', 'property.images','messages',  'sender')
            ->latest()
            ->limit(4)
        ->get();
        
        
        return Inertia::render('agent/Dashboard', [
            'user' => $user,
            'agent_viewings' => $viewings,
            'recent_enquiries' => $enquiries,
        ]);
    }
}
