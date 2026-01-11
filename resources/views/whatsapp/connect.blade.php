@extends('layouts.app')

@section('content')
<h2>Connect WhatsApp Device</h2>
<div class="alert alert-info">
    Need credentials? <a href="https://developers.facebook.com/docs/whatsapp/cloud-api/get-started" target="_blank" class="alert-link">Read the tutorial</a> on how to get them from Meta.
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('whatsapp.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Phone Number ID</label>
                <input type="text" class="form-control" name="phone_number_id" value="{{ $device->phone_number_id }}" placeholder="1000..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">WhatsApp Business Account ID</label>
                <input type="text" class="form-control" name="whatsapp_business_account_id" value="{{ $device->whatsapp_business_account_id }}" placeholder="2000..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Permanent Access Token</label>
                <input type="text" class="form-control" name="access_token" value="{{ $device->access_token }}" placeholder="EAAG..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Display Phone Number</label>
                <input type="text" class="form-control" name="phone_number" value="{{ $device->phone_number }}" placeholder="+1 555 000 000" required>
            </div>
            <button type="submit" class="btn btn-success">Connect Device</button>
        </form>
    </div>
</div>
@endsection
