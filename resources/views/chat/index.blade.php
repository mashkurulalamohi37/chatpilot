@extends('layouts.app')

@section('content')
<style>
    .chat-item { 
        transition: all 0.2s; 
        background-color: transparent; 
        border: 1px solid rgba(255, 255, 255, 0.1); 
    }
    .chat-item:hover { 
        background-color: rgba(255, 255, 255, 0.05); 
        transform: translateY(-1px); 
        cursor: pointer;
    }
    .chat-item.active-chat { 
        background-color: rgba(59, 130, 246, 0.2) !important; 
        border-color: #3b82f6;
    }
</style>
<div class="container-fluid" style="height: 80vh;">
    <div class="row h-100">
        <!-- Contact List -->
        <div class="col-md-4 overflow-auto h-100" style="border-right: 1px solid rgba(255,255,255,0.15);">
            <div class="list-group list-group-flush pt-3">
                @forelse($contacts as $contact)
                @php
                    $isActive = $selectedContact && $selectedContact->id == $contact->id;
                @endphp
                <div class="chat-item {{ $isActive ? 'active-chat' : '' }} rounded-3 mb-2 d-flex justify-content-between align-items-center px-3 py-3">
                    <a href="{{ route('chat.index', ['contact_id' => $contact->id]) }}" class="text-decoration-none text-reset flex-grow-1 min-width-0">
                        <div class="d-flex justify-content-between mb-1">
                            <h6 class="mb-0 text-truncate {{ $isActive ? 'fw-bold text-white' : 'fw-semibold text-white' }}">{{ $contact->name }}</h6>
                            <small class="{{ $isActive ? 'text-white' : 'text-secondary' }}" style="font-size: 0.75rem;">{{ $contact->updated_at->diffForHumans(null, true) }}</small>
                        </div>
                        <p class="mb-0 text-truncate small {{ $isActive ? 'text-white' : 'text-secondary' }}">{{ $contact->phone }}</p>
                    </a>
                    
                    <div class="dropdown ms-2">
                        <button class="btn btn-link text-secondary p-0 text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                              <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('contacts.edit', $contact->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil me-2 text-secondary" viewBox="0 0 16 16">
                                      <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                    Edit
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('contacts.destroy', $contact->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3 me-2" viewBox="0 0 16 16">
                                      <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                    </svg>
                                    Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                @empty
                <div class="p-3">No contacts found.</div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8 d-flex flex-column">
            @if($selectedContact)
                <!-- Header -->
                <div class="p-3 border-bottom" style="background-color: rgba(30, 41, 59, 0.5);">
                    <h5 class="mb-0 text-white">Chat with {{ $selectedContact->name }}</h5>
                </div>

                <!-- Messages -->
                <div class="flex-grow-1 p-4 overflow-auto" style="background-color: rgba(15, 23, 42, 0.5);">
                    @forelse($messages as $msg)
                        @if($msg->direction == 'inbound')
                        <!-- Incoming -->
                        <div class="d-flex mb-3">
                             <div class="p-3 rounded-4 shadow-sm" style="max-width: 70%; border-bottom-left-radius: 4px; background-color: #334155; color: #fff;">
                                {{ $msg->message_body }}
                                <div class="text-white-50 small text-end mt-1" style="font-size: 0.75rem;">{{ $msg->created_at->format('H:i') }}</div>
                             </div>
                        </div>
                        @else
                        <!-- Outbound -->
                        <div class="d-flex mb-3 justify-content-end">
                             <div class="bg-primary text-white p-3 rounded-4 shadow-sm" style="max-width: 70%; border-bottom-right-radius: 4px;">
                                {{ $msg->message_body }}
                                <div class="text-white small text-end mt-1 opacity-75" style="font-size: 0.75rem;">{{ $msg->created_at->format('H:i') }}</div>
                             </div>
                        </div>
                        @endif
                    @empty
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-chat-dots mb-3" viewBox="0 0 16 16">
                              <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                              <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"/>
                            </svg>
                            <p>No messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Input -->
                <div class="p-3 border-top shadow-sm" style="background-color: var(--bg-card);">
                    <form action="{{ route('chat.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="contact_id" value="{{ $selectedContact->id }}">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control rounded-start-pill ps-4 border-0" placeholder="Type a message..." required autofocus style="height: 50px; background-color: #334155; color: white;">
                            <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                  <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                    <h4>Select a contact to start chatting</h4>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
