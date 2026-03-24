<?php

namespace App\Http\Controllers\Agent;

use App\Enums\EnquiryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $enquiries = $user->enquiries_received()
            ->with('property', 'property.images','messages',  'sender')
            ->latest()
            ->paginate(100)
            ->withQueryString();
            
        return Inertia::render('agent/enquiry/Index', [
            'enquiries_data' => $enquiries,
            'statuses' => EnquiryStatus::values()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Enquiry $enquiry)
    {
        
        $user = $request->user();

        //check if user is the agent of the enquiry
        if ($enquiry->agent_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // mark all messages in the thread as read
        foreach ($enquiry->messages as $message) {
            if ($message->sender_id !== $user->id && $message->read_at === null) {
                $message->markAsRead();
            }
        }

        //  thread view, mark as read
        $enquiry->load('property', 'agent.agent_profile', 'sender','messages.sender');
        return Inertia::render('agent/enquiry/Show', [
            'enquiry' => $enquiry
        ]);
    }

     /**
     * Store a new message to an enquiry thread
     */
    public function storeMessage(StoreMessageRequest $request, Enquiry $enquiry)
    {
        $user = $request->user();

        // Check if user is the agent of the enquiry
        if ($enquiry->agent_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validated();
        
        $data['sender_id'] = $user->id;
        $enquiry->messages()->create($data);

        if($enquiry->status = EnquiryStatus::NEW)  {
            $enquiry->update(['status' => EnquiryStatus::IN_PROGRESS]);
        }

        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    public function markAsResolved(Request $request, Enquiry $enquiry)
    {
        $user = $request->user();

        // Check if user is the agent of the enquiry
        if ($enquiry->agent_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if($enquiry->status == EnquiryStatus::RESOLVED) {
            return redirect()->back()->with('info', 'Enquiry is already marked as resolved.');
        }

        $enquiry->update(['status' => EnquiryStatus::RESOLVED]);

        return redirect()->back()->with('success', 'Enquiry marked as resolved.');
    }
}
