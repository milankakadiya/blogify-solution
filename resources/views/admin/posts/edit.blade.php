@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Post</h1>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="bg-white rounded-lg shadow-md p-8">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title *</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}"
                class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Content *</label>
            <textarea name="content" rows="12"
                class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status *</label>
            <select name="status" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        @if($post->source)
        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <p class="text-sm text-gray-700">
                <strong>Import Source:</strong> <span class="text-blue-600">{{ ucfirst($post->source) }}</span> |
                <strong>External ID:</strong> <span class="text-blue-600">{{ $post->external_id }}</span>
            </p>
        </div>
        @endif

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                Update Post
            </button>
            <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
