<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsAppDevice;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\AiSetting;
use App\Services\WhatsAppService;
use App\Services\OpenAIService;

class WebhookController extends Controller
{
    protected $whatsappService;
    protected $openAIService;

    public function __construct(WhatsAppService $whatsappService, OpenAIService $openAIService)
    {
        $this->whatsappService = $whatsappService;
        $this->openAIService = $openAIService;
    }

    /**
     * Handle the verification verification request.
     */
    public function verify(Request $request)
    {
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        // rigorous verification logic would check against a stored verify token.
        // For simplicity/demo, we'll accept a generic one or assume env var.
        $verifyToken = env('WHATSAPP_VERIFY_TOKEN', 'chatpilot_secret');

        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $verifyToken) {
                return response($challenge, 200);
            }
        }

        return response()->json([], 403);
    }

    /**
     * Handle the incoming messages.
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        // Log::info('Webhook Payload:', $payload); // Debugging

        // Basic parsing of Meta webhook structure
        $entry = $payload['entry'][0] ?? null;
        $changes = $entry['changes'][0] ?? null;
        $value = $changes['value'] ?? null;

        if (!$value) {
            return response()->json([], 200);
        }

        // Identify the business account/phone number ID to find the SaaS User
        $phoneNumberId = $value['metadata']['phone_number_id'] ?? null;
        
        // Find the device/user
        $device = WhatsAppDevice::where('phone_number_id', $phoneNumberId)->first();

        if (!$device) {
            // Log::warning("Device not found for Phone ID: $phoneNumberId");
            return response()->json([], 200);
        }

        $messages = $value['messages'] ?? [];
        
        foreach ($messages as $msg) {
            $this->processMessage($msg, $device);
        }

        return response()->json([], 200);
    }

    protected function processMessage($msg, $device)
    {
        $from = $msg['from']; // User's phone number
        $text = $msg['text']['body'] ?? ''; // Currently parsing text only
        $type = $msg['type'];

        if ($type !== 'text') {
            // Handle other types later
            return;
        }

        // Find or Create Contact
        $contact = Contact::firstOrCreate(
            ['user_id' => $device->user_id, 'phone' => $from],
            ['name' => $payload['contacts'][0]['profile']['name'] ?? 'Unknown']
        );

        // Store Incoming Message
        Chat::create([
            'user_id' => $device->user_id,
            'contact_id' => $contact->id,
            'message_type' => 'text',
            'direction' => 'inbound',
            'message_body' => $text,
            'status' => 'read' // Auto-mark as read or handled
        ]);

        // Check AI Settings
        $aiSettings = AiSetting::where('user_id', $device->user_id)->first();

        if ($aiSettings && $aiSettings->is_active) {
            // Generate AI Reply
            $aiReply = $this->openAIService->generateReply(
                $text,
                $aiSettings->system_prompt,
                $aiSettings->openai_api_key
            );

            if ($aiReply) {
                // Send Reply via WhatsApp
                $this->whatsappService->sendMessage($from, $aiReply, $device);

                // Store Outbound Message
                Chat::create([
                    'user_id' => $device->user_id,
                    'contact_id' => $contact->id,
                    'message_type' => 'text',
                    'direction' => 'outbound',
                    'message_body' => $aiReply,
                    'status' => 'sent'
                ]);
            }
        }
    }
}
