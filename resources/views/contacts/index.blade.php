@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Contacts</h4>
        <a href="{{ route('contacts.create') }}" class="btn btn-primary">Add Contact</a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-secondary fw-semibold text-uppercase small ls-1">Name</th>
                    <th class="text-secondary fw-semibold text-uppercase small ls-1">Phone</th>
                    <th class="text-secondary fw-semibold text-uppercase small ls-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr>
                    <td class="align-middle fw-medium text-white">{{ $contact->name }}</td>
                    <td class="align-middle text-white">{{ $contact->phone }}</td>
                    <td class="align-middle">
                        <div class="dropdown">
                            <button class="btn btn-link text-white p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                  <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('contacts.edit', $contact->id) }}">Edit</a></li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('contacts.destroy', $contact->id) }}">
                                        Delete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No contacts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $contacts->links() }}
    </div>
</div>
@endsection
