<?php

namespace App\Http\Controllers;

use App\Enums\PropertyStatus;
use App\Enums\UserRole;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index(Request $request)
    {

        $user = $request->user();

        // Fetch data for guest homepage
        $data['featured_properties'] = Property::where('is_featured', true)
            ->where('status', PropertyStatus::ACTIVE)
            ->with(['images', 'address', 'agent'])
            ->limit(6)
            ->get();

        $data['recent_properties'] = Property::where('status', PropertyStatus::ACTIVE)
            ->with(['images', 'address', 'agent'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $data['stats'] = [
            'total_properties' => Property::where('status', PropertyStatus::ACTIVE)->count(),
            'total_agents' => \App\Models\User::where('role', UserRole::AGENT)->count(),
            'total_reviews' => Review::count(),
        ];

        $data['testimonials'] = Review::with(['user', 'property'])
            ->where('rating', '>=', 4)
            ->limit(3)
            ->get();
        

        if($user) {
            if($user->is_agent()) {
                return inertia('Home', $data);
            } else if($user->is_admin()) {
                return inertia('Home', $data);
            } else {
                return inertia('customer/Home', $data);
            }
        }
        
        
        return inertia('Home', $data);
    }
}