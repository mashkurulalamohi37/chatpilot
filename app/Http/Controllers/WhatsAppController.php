<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function connect()
    {
        $device = \App\Models\WhatsAppDevice::where('user_id', auth()->id())->first() ?? new \App\Models\WhatsAppDevice();
        return view('whatsapp.connect', compact('device'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone_number_id' => 'required|string',
            'whatsapp_business_account_id' => 'required|string',
            'access_token' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        \App\Models\WhatsAppDevice::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'phone_number_id' => $request->phone_number_id,
                'whatsapp_business_account_id' => $request->whatsapp_business_account_id,
                'access_token' => $request->access_token,
                'phone_number' => $request->phone_number,
                'status' => 'connected',
            ]
        );

        return redirect()->route('whatsapp.connect')->with('success', 'WhatsApp Device credentials saved successfully!');
    }
}
