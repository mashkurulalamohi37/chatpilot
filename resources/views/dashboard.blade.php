@extends('layouts.app')

@section('content')
<h2>Dashboard</h2>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card h-100" style="border-left: 4px solid #3b82f6;">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small ls-1 mb-2">Total Messages Sent</h6>
                <h2 class="card-title fw-bold text-white mb-0">{{ number_format($totalMessagesSent) }}</h2>
                <p class="card-text text-muted small mt-2">Messages sent this month.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100" style="border-left: 4px solid #10b981;">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small ls-1 mb-2">Campaigns Running</h6>
                <h2 class="card-title fw-bold text-white mb-0">{{ $campaignsRunning }}</h2>
                <p class="card-text text-muted small mt-2">Active bulk campaigns.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100" style="border-left: 4px solid #f59e0b;">
            <div class="card-body">
                <h6 class="text-uppercase text-muted small ls-1 mb-2">AI Credits Used</h6>
                <h2 class="card-title fw-bold text-white mb-0">${{ number_format($aiCreditsUsed, 2) }}</h2>
                <p class="card-text text-muted small mt-2">OpenAI usage this month.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-md border-0">
            <div class="card-header border-0 bg-transparent pt-4 px-4">
                <h5 class="mb-0 fw-bold text-white">Message Activity</h5>
            </div>
            <div class="card-body px-4 pb-4">
                <canvas id="messagesChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('messagesChart').getContext('2d');
        
        // Gradient for the chart
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)');   
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        const messagesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Messages Sent',
                    data: {!! json_encode($messageCounts) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#3b82f6',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94a3b8' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { 
                            color: '#94a3b8',
                            precision: 0 
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
