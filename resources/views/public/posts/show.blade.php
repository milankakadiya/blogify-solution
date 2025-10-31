@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800 mb-6 inline-flex items-center font-semibold">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to all posts
    </a>

    <article class="bg-white rounded-lg shadow-md p-8 mt-4">
        <h1 class="text-4xl font-bold mb-4 text-gray-900">{{ $post->title }}</h1>

        <div class="text-gray-600 text-sm mb-6 flex items-center space-x-4 pb-6 border-b">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Published {{ $post->created_at->format('F j, Y') }}
            </span>
            @if($post->source)
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                Source: {{ ucfirst($post->source) }}
            </span>
            @endif
        </div>

        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>

    <div class="mt-6 text-center">
        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
            ← View all posts
        </a>
    </div>
</div>
@endsection
