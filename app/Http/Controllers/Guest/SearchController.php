<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class SearchController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return paginated listing feed, filtering
        $properties = Property::query()
        ->when($request->search, fn($q) => 
            $q->where('title', 'like', "%{$request->search}%")
        )
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return inertia('guest/property/Index', [
            'properties'   => $properties,
            'filters' => $request->only(['search']),
        ]);
    }
}