<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a message via WhatsApp Cloud API.
     *
     * @param string $phone The recipient's phone number.
     * @param string|array $message The message content (text string or template array).
     * @param object $device The user's WhatsApp device credentials.
     * @return array|null Response from Meta or null on failure.
     */
    public function sendMessage($phone, $message, $device)
    {
        $url = "https://graph.facebook.com/v17.0/{$device->phone_number_id}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
        ];

        if (is_string($message)) {
            $payload['type'] = 'text';
            $payload['text'] = ['body' => $message];
        } elseif (is_array($message) && isset($message['template'])) {
             // Assuming $message is structured correctly for a template
            $payload['type'] = 'template';
            $payload['template'] = $message['template'];
        } else {
             // Fallback or other types can be handled here
            Log::warning("Unknown message format for WhatsAppService", ['message' => $message]);
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $device->access_token,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error("WhatsApp API Error: " . $response->body());
                return $response->json(); // Return error details
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp Service Exception: " . $e->getMessage());
            return null;
        }
    }
}
