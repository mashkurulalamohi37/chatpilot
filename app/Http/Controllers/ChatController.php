<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $contacts = \App\Models\Contact::all();
        $selectedContact = null;
        $messages = [];

        if ($request->has('contact_id')) {
            $selectedContact = \App\Models\Contact::find($request->contact_id);
            if ($selectedContact) {
                $messages = \App\Models\Chat::where('contact_id', $selectedContact->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        }

        return view('chat.index', compact('contacts', 'selectedContact', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'message' => 'required|string',
        ]);

        \App\Models\Chat::create([
            'user_id' => auth()->id(),
            'contact_id' => $request->contact_id,
            'message_type' => 'text',
            'direction' => 'outbound',
            'message_body' => $request->message,
            'status' => 'sent',
        ]);

        return redirect()->route('chat.index', ['contact_id' => $request->contact_id]);
    }
}
