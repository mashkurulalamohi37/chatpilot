<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiController extends Controller
{
    public function config()
    {
        $setting = \App\Models\AiSetting::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'openai_api_key' => '',
                'system_prompt' => 'You are a helpful assistant.',
                'is_active' => false
            ]
        );
        return view('ai.config', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'openai_api_key' => 'nullable|string',
            'system_prompt' => 'nullable|string',
        ]);

        $setting = \App\Models\AiSetting::where('user_id', auth()->id())->first();
        $setting->update([
            'openai_api_key' => $request->openai_api_key,
            'system_prompt' => $request->system_prompt,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('ai.config')->with('success', 'AI Settings updated successfully!');
    }
}
