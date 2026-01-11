<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Messages Sent: Sum of all sent_count from campaigns
        $totalMessagesSent = Campaign::sum('sent_count');

        // 2. Campaigns Running: Count of campaigns that are 'active', 'started', or 'running'
        $campaignsRunning = Campaign::whereNotIn('status', ['completed', 'draft'])->count();

        // 3. AI Credits Used: Sum of 'cost' from AiUsageLog
        $aiCreditsUsed = \App\Models\AiUsageLog::sum('cost') ?? 0;

        // 4. Monthly Activity Graph
        $monthlyStats = \App\Models\Chat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->startOfYear())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Prepare data for Chart.js (ensure all months roughly covered or just present data)
        // For simplicity, we'll map 1-12.
        $months = [];
        $messageCounts = [];
        for ($i = 1; $i <= 12; $i++) {
             $months[] = date("M", mktime(0, 0, 0, $i, 1));
             $messageCounts[] = $monthlyStats[$i] ?? 0;
        }

        return view('dashboard', compact('totalMessagesSent', 'campaignsRunning', 'aiCreditsUsed', 'months', 'messageCounts'));
    }
}
