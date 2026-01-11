<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $apiKey;

    /**
     * Generate a smart reply using OpenAI.
     *
     * @param string $userInput The customer's message.
     * @param string $systemPrompt The system instruction (bot persona).
     * @param string $apiKey The user's OpenAI API Key.
     * @return string The generated response.
     */
    public function generateReply($userInput, $systemPrompt, $apiKey)
    {
        $url = "https://api.openai.com/v1/chat/completions";

        $payload = [
            'model' => 'gpt-4', // Or gpt-3.5-turbo
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $userInput
                ]
            ],
            'temperature' => 0.7,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                // Log Usage
                if (isset($data['usage'])) {
                    $inputTokens = $data['usage']['prompt_tokens'] ?? 0;
                    $outputTokens = $data['usage']['completion_tokens'] ?? 0;
                    
                    // GPT-4 Pricing (Approx)
                    // Input: $0.03 / 1k tokens = $0.00003
                    // Output: $0.06 / 1k tokens = $0.00006
                    $cost = ($inputTokens * 0.00003) + ($outputTokens * 0.00006);
                    
                    try {
                        \App\Models\AiUsageLog::create([
                            'user_id' => auth()->id(),
                            'request_type' => 'chat_completion',
                            'input_tokens' => $inputTokens,
                            'output_tokens' => $outputTokens,
                            'cost' => $cost,
                        ]);
                    } catch (\Exception $e) {
                         // Silently fail logging to not disrupt service
                         Log::error("Failed to log AI usage: " . $e->getMessage());
                    }
                }

                return $data['choices'][0]['message']['content'] ?? "I'm sorry, I couldn't generate a response.";
            } else {
                Log::error("OpenAI API Error: " . $response->body());
                return "Error generating response. Please check your settings.";
            }
        } catch (\Exception $e) {
            Log::error("OpenAI Service Exception: " . $e->getMessage());
            return "An internal error occurred.";
        }
    }
}
