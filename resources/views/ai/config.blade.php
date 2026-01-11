@extends('layouts.app')

@section('content')
<h2>AI Configuration</h2>
<p>Configure the "brain" of your bot.</p>

<div class="card">
    <div class="card-body">
        <form action="{{ route('ai.update') }}" method="POST">
            @csrf
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="aiActive" name="is_active" {{ $setting->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="aiActive">Enable AI Auto-Reply</label>
            </div>

            <div class="mb-3">
                <label class="form-label">OpenAI API Key</label>
                <input type="password" class="form-control" name="openai_api_key" value="{{ $setting->openai_api_key }}" placeholder="sk-...">
            </div>

            <div class="mb-3">
                <label class="form-label">System Prompt (Bot Instructions)</label>
                <textarea class="form-control" name="system_prompt" rows="5">{{ $setting->system_prompt }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</div>
@endsection
