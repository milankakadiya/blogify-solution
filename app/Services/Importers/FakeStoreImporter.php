<?php

namespace App\Services\Importers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FakeStoreImporter implements ImporterInterface
{
    private const BASE_URL = 'https://fakestoreapi.com';
    private const MAX_ID = 20;

    public function import(): ?array
    {
        try {
            $randomId = rand(1, self::MAX_ID);
            $response = Http::timeout(10)->get(self::BASE_URL . "/products/{$randomId}");

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'title' => $data['title'] ?? 'Untitled Product',
                    'content' => $this->transformProductContent($data),
                    'external_id' => (string)$data['id'],
                    'source' => $this->getSourceName(),
                ];
            }

            Log::error('FakeStore API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('FakeStore import exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    private function transformProductContent(array $product): string
    {
        $content = $product['description'] ?? '';

        if (isset($product['price'])) {
            $content .= "\n\nPrice: $" . $product['price'];
        }

        if (isset($product['category'])) {
            $content .= "\nCategory: " . ucfirst($product['category']);
        }

        return $content;
    }

    public function getSourceName(): string
    {
        return 'fakestore';
    }
}
