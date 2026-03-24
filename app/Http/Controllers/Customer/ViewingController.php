<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreViewingRequest;
use App\Models\Viewing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViewingController extends Controller
{

    public function index(Request $request)
    {
        // list of all viewings for the customer
        $viewings = $request->user()->viewings()
            ->with('property', 'agent.agent_profile')
            ->latest()
            ->paginate(10);

        return Inertia::render('customer/viewings/Index', [
            'viewings' => $viewings
        ]);
    }

    public function show(Viewing $viewing)
    {
        // details of a specific viewing
        $viewing->load('property', 'agent.agent_profile');
        return Inertia::render('customer/viewings/Show', [
            'viewing' => $viewing
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreViewingRequest $request)
    {
        //  request a property viewing

    }
}
