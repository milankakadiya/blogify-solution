<?php

namespace App\Services\Importers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JsonPlaceholderImporter implements ImporterInterface
{
    private const BASE_URL = 'https://jsonplaceholder.typicode.com';
    private const MAX_ID = 100;

    public function import(): ?array
    {
        try {
            $randomId = rand(1, self::MAX_ID);
            $response = Http::timeout(10)->get(self::BASE_URL . "/posts/{$randomId}");

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'title' => $data['title'] ?? 'Untitled',
                    'content' => $data['body'] ?? '',
                    'external_id' => (string)$data['id'],
                    'source' => $this->getSourceName(),
                ];
            }

            Log::error('JSONPlaceholder API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('JSONPlaceholder import exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function getSourceName(): string
    {
        return 'jsonplaceholder';
    }
}
