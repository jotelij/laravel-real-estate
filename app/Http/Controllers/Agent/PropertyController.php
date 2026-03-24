<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Amenity;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        // $properties = Property::where('agent_id', $agentId)->latest()->paginate(10);
        
        $properties = $user->properties()
        ->with('images', 'agent', 'amenities', 'address')
        ->latest()
        ->paginate(100);

        return Inertia::render('agent/property/Index', [
            'properties_data' => $properties,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // new listing form
        $countries = Country::all();
        $amenities = Amenity::all();

        return Inertia::render('agent/property/Create', [
            'countries' => $countries,
            'amenities' => $amenities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        // save listing + handle image uploads
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load('images', 'agent', 'amenities', 'address');
        return Inertia::render('agent/property/Show', [
            'property' => $property,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $property->load('images', 'agent', 'amenities', 'address');
        return Inertia::render('agent/property/Edit', [
            'property' => $property,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        // archive listing
    }
}
