<?php

namespace  App\Http\Controllers\Customer;

use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavouriteController extends Controller {

    public function index(Request $request)
    {
        $user = $request->user();

        $favourite_properties = $user->favourites()
            ->with('images')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('customer/favourites/Index', [
            'favourite_properties' => $favourite_properties,
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourite $favourite)
    {
        $favourite->delete();

        return inertia();
    }
}