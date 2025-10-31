<?php

namespace App\Services;

use App\Models\Post;
use App\Services\Importers\ImporterInterface;
use Illuminate\Support\Facades\Log;

class PostImportService
{
    public function importFromSource(ImporterInterface $importer): array
    {
        try {
            $data = $importer->import();

            if (!$data) {
                return [
                    'success' => false,
                    'message' => 'Failed to fetch data from ' . $importer->getSourceName()
                ];
            }

            $existing = Post::where('source', $data['source'])
                ->where('external_id', $data['external_id'])
                ->first();

            if ($existing) {
                return [
                    'success' => false,
                    'message' => 'Post already imported (ID: ' . $existing->id . ')',
                    'post' => $existing
                ];
            }

            $post = Post::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'external_id' => $data['external_id'],
                'source' => $data['source'],
                'status' => 'draft'
            ]);

            return [
                'success' => true,
                'message' => 'Post imported successfully as draft (ID: ' . $post->id . ')',
                'post' => $post
            ];

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return [
                    'success' => false,
                    'message' => 'Duplicate entry detected'
                ];
            }

            Log::error('Database error during import', [
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Database error occurred'
            ];
        } catch (\Exception $e) {
            Log::error('Import service exception', [
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred during import'
            ];
        }
    }
}
