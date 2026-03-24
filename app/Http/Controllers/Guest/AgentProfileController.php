<?php

namespace App\Http\Controllers\Guest;

use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\AgentProfile;
use Illuminate\Http\Request;

class AgentProfileController extends Controller {
    /**
     * Display the specified resource.
     */
    public function show(Request $request, AgentProfile $agent_profile)
    {
        // public agent profile + their listings + reviews
        $agent_profile->load('user', 'properties', 'properties.images', 'reviews');
        $data = [
            'agent_data' => $agent_profile,
                'options' => [
                'property_types' => array_map(fn($e) => [
                    'value' => $e->value,
                    'label' => $e->label(),
                ], PropertyType::cases()),
                'listing_types' => array_map(fn($e) => [
                    'value'      => $e->value,
                    'label'      => $e->label(),
                ], ListingType::cases()),
                'statuses' => array_map(fn($e) => [
                    'value'      => $e->value,
                    'label'      => $e->label(),
                    'badgeClass' => $e->badgeClass(),
                ], PropertyStatus::cases()),
            ]
        ];

        $user = $request->user();

        // if the user is guests, show them the guest listing page
        if($user != null && $user->is_customer()) {
            return inertia('customer/agent/Show', $data);
        }

        return inertia('guest/agent/Show', $data);
    }
}