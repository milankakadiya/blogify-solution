@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Latest Blog Posts</h1>
        <p class="text-gray-600">Discover our collection of articles and insights</p>
    </div>

    @forelse($posts as $post)
    <article class="bg-white rounded-lg shadow-md p-6 mb-6 hover:shadow-lg transition">
        <h2 class="text-2xl font-bold mb-3">
            <a href="{{ route('posts.show', $post) }}" class="text-gray-900 hover:text-blue-600 transition">
                {{ $post->title }}
            </a>
        </h2>

        <div class="text-gray-600 text-sm mb-4 flex items-center space-x-4">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $post->created_at->format('F j, Y') }}
            </span>
            @if($post->source)
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                📡 {{ ucfirst($post->source) }}
            </span>
            @endif
        </div>

        <p class="text-gray-700 mb-4 leading-relaxed">
            {{ Str::limit(strip_tags($post->content), 250) }}
        </p>

        <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
            Read more
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </article>
    @empty
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p class="text-gray-500 text-lg mb-4">No published posts yet.</p>
        <a href="{{ route('admin.posts.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
            Go to Admin Panel →
        </a>
    </div>
    @endforelse

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection
