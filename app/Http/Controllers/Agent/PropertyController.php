<?php

namespace App\Http\Controllers\Agent;

use App\Enums\ListingType;
use App\Enums\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Amenity;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Country;
use App\Models\PropertyAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
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
    public function store(Request $request)
    {
        // validate the request data and create the property
        $validatedPropertyData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'property_type' => ['required', new Enum(PropertyType::class)],
            'listing_type' => ['required', new Enum(ListingType::class)],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'garages' => ['nullable', 'integer', 'min:0', 'max:255'],
            'floor_area' => ['nullable', 'numeric', 'min:0'],
            'land_area' => ['nullable', 'numeric', 'min:0'],
            'year_built' => ['nullable', 'integer', 'digits:4', 'min:1800', 'max:' . (date('Y') + 1)],
            'is_featured' => ['sometimes', 'boolean'],
            'virtual_tour_link' => ['nullable', 'string', 'url', 'max:255'],
        ]);

        // validate the address data and create the address
        $validatedAddressData = $request->validate([
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:20'],
            'country_id' => ['required', 'exists:countries,id'],
        ]);

        $validatedAmenitiesData = $request->validate([
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['exists:amenities,id'],
        ]);

        $user = $request->user();

        // check if the user is an agent
        if (!$user || !$user->is_agent()) {
            abort(403, 'Unauthorized');
        }

        $agent = $user->agent_profile()->first();

        // first: create the property with the basic details (without address and amenities)
        $property = new Property($validatedPropertyData);
        $property->agent_id = $agent->id;
        $property->save();

        // second: create the address and associate it with the property
        $property->address()->create($validatedAddressData);
        $property->save();

        // third: associate the amenities with the property
        if (!empty($validatedAmenitiesData['amenities'])) {
            $property->amenities()->attach($validatedAmenitiesData['amenities']);
            $property->save();
        }
        // TODO: fourth: handle image uploads and associate them with the property
        return redirect()->route('agent.properties.index')->with('success', 'Property created successfully.');
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
