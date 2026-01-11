@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Add Contact</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('contacts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Contact</button>
        </form>
    </div>
</div>
@endsection
