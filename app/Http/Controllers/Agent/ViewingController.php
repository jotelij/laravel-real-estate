<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateViewingRequest;
use App\Models\Viewing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ViewingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agent = Auth::user();
        
        // Fetch viewings for the authenticated agent
        $viewings = Viewing::where('agent_id', $agent->id)
            ->with(['property', 'buyer'])
            ->orderBy('scheduled_at', 'asc')
            ->get();

        // Group viewings by date
        $groupedViewings = $viewings->groupBy(function ($viewing) {
            return $viewing->scheduled_at->format('Y-m-d');
        })->map(function ($group) {
            return $group->sortBy(function ($viewing) {
                return $viewing->scheduled_at->format('H:i');
            });
        });

        // Get all dates that have viewings for calendar highlighting
        $viewingDates = $viewings->pluck('scheduled_at')
            ->map(fn ($date) => $date->format('Y-m-d'))
            ->unique()
            ->values()
            ->toArray();

        return Inertia::render('agent/viewings/Index', [
            'groupedViewings' => $groupedViewings,
            'viewingDates' => $viewingDates,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateViewingRequest $request, Viewing $viewing)
    {
        // confirm / cancel viewing
    }
}
