<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Chat;

class CheckPlanLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user is on Free plan
        if ($user->role !== 'admin' && ($user->plan_id === 'free' || is_null($user->plan_id))) {
            
            // Count messages sent this month
            // Assuming 'chats' table tracks individual messages. 
            // For campaigns, we might check 'sent_count' in campaigns table too, 
            // but for now let's count total outbound chats.
            $count = Chat::where('user_id', $user->id)
                ->where('direction', 'outbound')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            // Limit: 100 messages for free plan
            if ($user->messagesSentThisMonth() >= 100) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Plan limit reached. Upgrade to send more messages.'], 403);
                }
                return redirect()->route('dashboard')->with('error', 'Plan limit reached. Please upgrade.');
            }
        }

        return $next($request);
    }
}
