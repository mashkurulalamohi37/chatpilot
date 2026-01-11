<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = \App\Models\Campaign::where('user_id', auth()->id())->latest()->get();
        return view('campaigns.index', compact('campaigns'));
    }

    public function show(\App\Models\Campaign $campaign)
    {
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }
        return view('campaigns.show', compact('campaign'));
    }

    public function create()
    {
        $contacts = \App\Models\Contact::all();
        return view('campaigns.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
        ]);

        $campaign = \App\Models\Campaign::create([
            'name' => $request->name,
            'template_name' => $request->message, // Mapping message input to template_name column
            'status' => 'pending',
            'total_contacts' => count($request->contacts),
            'user_id' => auth()->id(),
        ]);

        // Dispatch Messages
        $contacts = \App\Models\Contact::whereIn('id', $request->contacts)->get();
        
        foreach ($contacts as $contact) {
            \App\Jobs\SendCampaignMessage::dispatch($campaign, $contact, $request->message);
        }

        $campaign->update(['status' => 'processing']);

        return redirect()->route('campaigns.create')->with('success', 'Campaign created and processing started!');
    }
}
