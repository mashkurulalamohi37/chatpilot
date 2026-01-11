<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = \App\Models\Contact::latest()->paginate(10);
        // We might not have a dedicated index view yet, but let's assume one or return generic view
        // For now, let's return a simple view if it exists, otherwise just the data for testing
        // Checking task list, we need to implement contact management.
        // Let's assume there is a contacts.index view or we will create one later.
        // For now, specifically for the campaign flow, we need to create contacts.
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:contacts,phone',
            'email' => 'nullable|email|max:255',
        ]);

        // Bug Fix: user_id is required by schema
        $validated['user_id'] = auth()->id();

        \App\Models\Contact::create($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }

    public function edit(\App\Models\Contact $contact)
    {
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, \App\Models\Contact $contact)
    {
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:contacts,phone,'.$contact->id,
            'email' => 'nullable|email|max:255',
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }

    public function destroy(\App\Models\Contact $contact)
    {
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }
        $contact->delete();
        return back()->with('success', 'Contact deleted successfully.');
    }
}
