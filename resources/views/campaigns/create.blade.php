@extends('layouts.app')

@section('content')
<h2>Create Campaign</h2>
<p>Select contacts and send a bulk message.</p>

<div class="card">
    <div class="card-body">
        <form action="{{ route('campaigns.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Campaign Name</label>
                <input type="text" class="form-control" name="name" placeholder="Summer Sale" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Message Template / Body</label>
                <textarea class="form-control" name="message" rows="3" placeholder="Hello @{{name}}, check out our new offers!" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Contacts</label>
                <div class="list-group">
                    @if($contacts->count() > 0)
                    <label class="list-group-item fw-bold text-white mb-1 rounded border-0" style="background-color: rgba(59, 130, 246, 0.2);">
                        <input class="form-check-input me-2" type="checkbox" id="selectAll">
                        Select All
                    </label>
                    @endif
                    @forelse($contacts as $contact)
                    <label class="list-group-item text-white-50 border-0 mb-1 rounded" style="background-color: rgba(255, 255, 255, 0.05);">
                        <input class="form-check-input me-2 contact-checkbox" type="checkbox" name="contacts[]" value="{{ $contact->id }}">
                        {{ $contact->name }} ({{ $contact->phone }})
                    </label>
                    @empty
                    <div class="alert alert-warning">No contacts found. Please add contacts first.</div>
                    @endforelse
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Send Campaign</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.contact-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        }
    });
</script>
@endsection
