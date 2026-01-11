@extends('layouts.app')

@section('content')
<div class="card text-center">
    <div class="card-body">
        <h1 class="text-success display-4">Payment Successful!</h1>
        <p class="lead">Thank you for upgrading to ChatPilot Pro.</p>
        <p>Your plan limits have been increased.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
    </div>
</div>
@endsection
