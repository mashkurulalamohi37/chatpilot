@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Campaigns</h2>
    <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg me-1" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
        </svg>
        New Campaign
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-top-0 ps-4">Name</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0">Progress</th>
                        <th class="border-top-0 text-end pe-4">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                    <tr>
                        <td class="ps-4 align-middle">
                            <a href="{{ route('campaigns.show', $campaign->id) }}" class="text-decoration-none text-white">
                                <h6 class="mb-0 fw-semibold">{{ $campaign->name }}</h6>
                            </a>
                        </td>
                        <td class="align-middle">
                            @if($campaign->status == 'completed')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Completed</span>
                            @elseif($campaign->status == 'processing')
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Processing</span>
                            @elseif($campaign->status == 'failed')
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Failed</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">{{ ucfirst($campaign->status) }}</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-white small">{{ $campaign->sent_count }} / {{ $campaign->total_contacts }}</span>
                                <div class="progress flex-grow-1" style="height: 6px; width: 100px; background-color: rgba(255,255,255,0.1);">
                                    @php
                                        $percent = $campaign->total_contacts > 0 ? ($campaign->sent_count / $campaign->total_contacts) * 100 : 0;
                                    @endphp
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-4 align-middle text-secondary small">
                            {{ $campaign->created_at->format('M d, Y h:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-megaphone opacity-50" viewBox="0 0 16 16">
                                  <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.817-6.5-2.09V4.815c2.01.273 4.338.85 6.5 2.09V2.5zm-5.5 1.243c1.914-.28 4.37-.9 6.833-2.105a.5.5 0 0 1 .667.443v11.53a.5.5 0 0 1-.667.443c-2.463-1.205-4.919-1.824-6.833-2.104V3.743z"/>
                                  <path d="M8 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 13a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </div>
                            <p class="mb-0">No campaigns found.</p>
                            <a href="{{ route('campaigns.create') }}" class="btn btn-link text-decoration-none">Create your first campaign</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
