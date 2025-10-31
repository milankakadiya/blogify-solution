@extends('layouts.app')

@section('title', 'Import Posts')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-2 text-gray-800">Import Posts from External APIs</h1>
    <p class="text-gray-600 mb-6">Fetch and transform content from different sources into blog posts</p>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('admin.imports.import') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-4">Select API Source</label>

                <div class="space-y-4">
                    <label class="flex items-start p-5 border-2 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-400 transition">
                        <input type="radio" name="source" value="jsonplaceholder" class="mt-1 mr-4" required>
                        <div class="flex-1">
                            <div class="font-semibold text-lg text-gray-800">JSONPlaceholder API</div>
                            <div class="text-sm text-gray-600 mt-1">Import random blog post from JSONPlaceholder</div>
                            <div class="text-xs text-gray-500 mt-2">
                                <strong>Endpoint:</strong> https://jsonplaceholder.typicode.com/posts/{randomId}
                            </div>
                        </div>
                    </label>

                    <label class="flex items-start p-5 border-2 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-400 transition">
                        <input type="radio" name="source" value="fakestore" class="mt-1 mr-4" required>
                        <div class="flex-1">
                            <div class="font-semibold text-lg text-gray-800">FakeStore API</div>
                            <div class="text-sm text-gray-600 mt-1">Import random product (transformed to blog post)</div>
                            <div class="text-xs text-gray-500 mt-2">
                                <strong>Endpoint:</strong> https://fakestoreapi.com/products/{randomId}
                            </div>
                        </div>
                    </label>
                </div>

                @error('source')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Important:</strong> Imported posts are saved as <strong>drafts</strong>.
                            Duplicate posts (same source + external ID) will be automatically prevented.
                        </p>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white px-6 py-4 rounded-lg hover:bg-blue-600 transition font-bold text-lg">
                🚀 Import Now
            </button>
        </form>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h3 class="font-bold text-lg mb-3 text-gray-800">How It Works</h3>
        <ol class="list-decimal list-inside space-y-2 text-gray-600 text-sm">
            <li>Select an API source from the options above</li>
            <li>Click "Import Now" to fetch a random item from that API</li>
            <li>The data will be transformed and saved as a draft post</li>
            <li>Go to "Admin Posts" to edit and publish the imported content</li>
            <li>Duplicate imports are automatically prevented by source + external ID</li>
        </ol>
    </div>
</div>
@endsection
