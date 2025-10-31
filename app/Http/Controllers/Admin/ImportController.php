<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PostImportService;
use App\Services\Importers\JsonPlaceholderImporter;
use App\Services\Importers\FakeStoreImporter;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected PostImportService $importService;

    public function __construct(PostImportService $importService)
    {
        $this->importService = $importService;
    }

    public function index()
    {
        return view('admin.imports.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'source' => 'required|in:jsonplaceholder,fakestore'
        ]);

        $importer = match($request->source) {
            'jsonplaceholder' => new JsonPlaceholderImporter(),
            'fakestore' => new FakeStoreImporter(),
            default => null
        };

        if (!$importer) {
            return back()->with('error', 'Invalid source selected');
        }

        $result = $this->importService->importFromSource($importer);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
