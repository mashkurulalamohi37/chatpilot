<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = Auth::user();

        // Create a Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'ChatPilot Pro Plan',
                    ],
                    'unit_amount' => 2900, // $29.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment', // Or 'subscription'
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('dashboard'),
            'client_reference_id' => $user->id,
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // verify session_id if needed using Stripe API
        // For simplicity/MVP, we'll just update the user here assuming valid redirect
        // In production, rely ideally on the webhook for security.
        
        return view('payment.success');
    }

    public function webhook(Request $request)
    {
        // This is the robust way to handle payments
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                
                // Fullfill the purchase
                $userId = $session->client_reference_id;
                $user = User::find($userId);
                
                if ($user) {
                    $user->plan_id = 'pro';
                    $user->plan_expires_at = now()->addMonth();
                    $user->save();
                    Log::info("User {$user->id} upgraded to Pro via Webhook");
                }
                break;
            default:
                // Unexpected event type
                echo 'Received unknown event type ' . $event->type;
        }

        return response('Success', 200);
    }
}
