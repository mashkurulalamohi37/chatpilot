@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('campaigns.index') }}" class="text-decoration-none text-muted"> < Back to Campaigns</a>
    </div>

    <div class="row">
        <!-- Main Stats -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="mb-1 fw-bold">{{ $campaign->name }}</h3>
                            <p class="text-muted small">Created on {{ $campaign->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @if($campaign->status == 'completed')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fs-6">Completed</span>
                        @elseif($campaign->status == 'processing')
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-6">Processing</span>
                        @elseif($campaign->status == 'failed')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fs-6">Failed</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill fs-6">{{ ucfirst($campaign->status) }}</span>
                        @endif
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 text-center" style="background-color: rgba(255,255,255,0.05);">
                                <h6 class="text-white-50 text-uppercase small ls-1">Total Contacts</h6>
                                <h2 class="mb-0 fw-bold">{{ $campaign->total_contacts }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 text-center" style="background-color: rgba(255,255,255,0.05);">
                                <h6 class="text-white-50 text-uppercase small ls-1">Sent</h6>
                                <h2 class="mb-0 fw-bold text-success">{{ $campaign->sent_count }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 text-center" style="background-color: rgba(255,255,255,0.05);">
                                <h6 class="text-white-50 text-uppercase small ls-1">Pending</h6>
                                <h2 class="mb-0 fw-bold text-white-50">{{ $campaign->total_contacts - $campaign->sent_count }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header border-0 bg-transparent py-3">
                     <h5 class="mb-0 fw-bold text-white">Message Content</h5>
                </div>
                <div class="card-body">
                    <div class="p-3 rounded-3 border border-secondary" style="background-color: rgba(255,255,255,0.05);">
                        <p class="mb-0 text-white-50" style="white-space: pre-line;">{{ $campaign->template_name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Tips -->
        <div class="col-md-4">
            <div class="card bg-primary text-white border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold">Tips</h5>
                    <p class="small opacity-75">Campaigns are processed in the background. If the status is stuck on "Pending", please check your Queue Worker.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
