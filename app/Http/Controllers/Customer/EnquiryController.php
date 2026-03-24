<?php

namespace App\Http\Controllers\Customer;

use App\Enums\EnquiryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnquiryRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnquiryController extends Controller
{

    public function index(Request $request)
    {   
        $user = $request->user();
        $enquiries = $user->enquiries_sent()
            ->with('property', 'messages',  'agent.agent_profile')
            ->latest()
            ->paginate(100)
            ->withQueryString();
            
        return Inertia::render('customer/enquiry/Index', [
            'enquiries_data' => $enquiries,
            'statuses' => EnquiryStatus::values()
        ]);
    }

    public function show(Request $request, Enquiry $enquiry)
    {
        // $enquiry->load('property', 'agent.agent_profile', 'messages.sender');

        $user = $request->user();

        //check if user is the sender of the enquiry
        if ($enquiry->sender_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // mark all messages in the thread as read
        foreach ($enquiry->messages as $message) {
            if ($message->sender_id !== $user->id && $message->read_at === null) {
                $message->markAsRead();
            }
        }

        return Inertia::render('customer/enquiry/Show', [
            'enquiry' => $enquiry
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnquiryRequest $request)
    {
        // submit new enquiry

        $data = $request->validated();
        $user = $request->user();

        // create a new enquiry associated with the user
        $user->enquiries()->create($data);
        return redirect()->back()->with('success', 'Enquiry submitted successfully.');
    }

    /**
     * Store a new message to an enquiry thread
     */
    public function storeMessage(StoreMessageRequest $request, Enquiry $enquiry)
    {
        $user = $request->user();

        // Check if user is the sender of the enquiry
        if ($enquiry->sender_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validated();
        $data['sender_id'] = $user->id;

        $enquiry->messages()->create($data);

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
}
