<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\WhatsAppDevice;
use App\Models\Chat;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class SendCampaignMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;
    protected $contact;
    protected $messageContent;

    /**
     * Create a new job instance.
     */
    public function __construct(Campaign $campaign, Contact $contact, $messageContent)
    {
        $this->campaign = $campaign;
        $this->contact = $contact;
        $this->messageContent = $messageContent;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsAppService)
    {
        $user = $this->campaign->user; // Assuming relationship exists, or use user_id
        
        // Find device for the campaign's user
        $device = WhatsAppDevice::where('user_id', $this->campaign->user_id)->first();

        if (!$device || $device->status !== 'connected') {
            Log::error("Campaign {$this->campaign->id} failed for contact {$this->contact->id}: No connected device for user {$this->campaign->user_id}");
            return;
        }

        // Send via Service
        $response = $whatsAppService->sendMessage(
            $this->contact->phone,
            $this->messageContent,
            $device
        );

        if ($response) {
            // Log Chat
            Chat::create([
                'user_id' => $this->campaign->user_id,
                'contact_id' => $this->contact->id,
                'message_type' => 'text',
                'direction' => 'outbound',
                'message_body' => $this->messageContent,
                'status' => 'sent',
            ]);

            // Increment Stats
            $this->campaign->increment('sent_count');
        } else {
            Log::error("Failed to send campaign message to {$this->contact->phone}");
        }
    }
}
