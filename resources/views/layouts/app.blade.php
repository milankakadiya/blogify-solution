<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blogify')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex space-x-1">
                    <a href="{{ route('posts.index') }}" class="px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded font-semibold">
                        Public Blog
                    </a>
                    <span class="text-gray-400 py-2">|</span>
                    <a href="{{ route('admin.posts.index') }}" class="px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded font-semibold">
                        Admin Posts
                    </a>
                    <a href="{{ route('admin.imports.index') }}" class="px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded font-semibold">
                        Import
                    </a>
                </div>
                <div class="text-2xl font-bold text-blue-600">
                    Blogify
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-600">
            <p>&copy; 2025 Blogify - Blog Platform with Content Importer</p>
        </div>
    </footer>
</body>
</html>
