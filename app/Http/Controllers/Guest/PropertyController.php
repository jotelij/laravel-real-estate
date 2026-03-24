<?php

namespace App\Http\Controllers\Guest;

use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PropertyController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'property_types'   => ['sometimes', 'array'],
            'property_types.*' => ['integer', new Enum(PropertyType::class)],
            'listing_types'    => ['sometimes', 'array'],
            'listing_types.*'  => ['integer', new Enum(ListingType::class)],
            'statuses'         => ['sometimes', 'array'],
            'statuses.*'       => ['integer', new Enum(PropertyStatus::class)],
            'max_price'    => ['sometimes', 'numeric', 'min:0'],
            // 'min_rating'   => ['sometimes', 'numeric', 'min:0', 'max:5'],
            'sort'         => ['sometimes', 'string', 'in:default,price-asc,price-desc,rating,name'],
        ]);

        // return paginated listing feed, filtering
        $properties = Property::query()
        ->when($request->search, fn($q) => 
            $q->where('title', 'like', "%{$request->search}%")
        )
        ->when($request->property_types, fn($q) =>
            $q->whereIn('property_type', $request->property_types)
        )
        ->when($request->listing_types, fn($q) =>
            $q->whereIn('listing_type', $request->listing_types)
        )
        ->when($request->statuses, fn($q) =>
            $q->whereIn('status', $request->statuses)
        )
        ->when($request->max_price, fn($q) =>
            $q->where('price', '<=', $request->max_price)
        )->with('images')
        ->latest()
        ->paginate(10)
        ->withQueryString();

        $final_options = [
            'properties_data' => $properties,
            'filters' => $request->only([
                'search', 'property_types', 'listing_types', 'statuses',
                'max_price', 'sort'
            ]),
            // Pass enum options to Vue — single source of truth
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
            ],
        ];

        $user = $request->user();

        // if the user is guests, show them the guest listing page
        if($user != null && $user->is_customer()) {
            return inertia('customer/property/Index', $final_options);
        }

        return inertia('guest/property/Index', $final_options);
    }

    /**
     * Display a listing of the resource.
     */
    public function show(Request $request, Property $property)
    {
        $property->load('images', 'agent', 'amenities', 'address');
        // single property detail + increment view count
        $data = [
            'property_data' => $property,
            // Pass enum options to Vue — single source of truth
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
            ],
        ];

        $user = $request->user();

        // if the user is guests, show them the guest listing page
        if($user != null && $user->is_customer()) {
            return inertia('customer/property/Show', $data);
        }

        return inertia('guest/property/Show', $data);
    }
}