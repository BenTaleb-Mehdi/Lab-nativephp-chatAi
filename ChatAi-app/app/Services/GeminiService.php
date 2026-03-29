<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected string $apiKey;
    protected string $model = 'gemini-2.5-flash';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function chat(string $message, array $history = []): string
    {
        if (!$this->apiKey) {
            throw new \RuntimeException('GEMINI_API_KEY is missing in .env');
        }

     
        $contents = [];

        foreach ($history as $turn) {
            $contents[] = [
                'role'  => $turn['role'],          
                'parts' => [['text' => $turn['text']]],
            ];
        }

        // Append current user message
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $message]],
        ];

        $response = Http::withOptions(['verify' => false]) // fixes SSL issues on Windows/localhost
            ->timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}", [
                'contents'         => $contents,
                'generationConfig' => [
                    'temperature'     => 0.9,
                    'maxOutputTokens' => 2048,
                ],
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('Gemini API error ' . $response->status() . ': ' . $response->body());
        }

        $data = $response->json();

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No response from Gemini.';
    }
}