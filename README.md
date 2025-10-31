# 🚀 Blogify - Blog Platform with Content Importer

A Laravel-based blog platform that seamlessly imports and transforms content from external APIs into consistent blog posts. Built as a technical demonstration of API integration, data transformation, and clean architecture principles.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Architecture](#architecture)
- [Installation](#installation)
- [Usage Guide](#usage-guide)
- [API Integration](#api-integration)
- [Adding New API Sources](#adding-new-api-sources)
- [Project Structure](#project-structure)
- [Development Process](#development-process)
- [Proposed Improvements](#proposed-improvements)
- [Screenshots](#screenshots)
- [Time Spent](#time-spent)
- [License](#license)

---

## 🎯 Overview

Blogify is a full-stack web application that demonstrates:

- **API Integration**: Fetching data from multiple external APIs
- **Data Transformation**: Converting different data structures into a unified format
- **Clean Architecture**: Service-oriented design with clear separation of concerns
- **Duplicate Prevention**: Database-level constraints to prevent duplicate imports
- **User Experience**: Intuitive admin panel and public blog interface

### The Challenge

Transform disparate data structures from different APIs into consistent blog posts:

**JSONPlaceholder** (Blog Posts)

{
"id": 1,
"title": "blog post title",
"body": "blog post content"
}

**FakeStore API** (Products → Blog Posts)

{
"id": 1,
"title": "Product Name",
"description": "Product description",
"price": 109.95,
"category": "product category"
}

---

## ✨ Features

### Core Functionality
- ✅ **CRUD Operations**: Full create, read, update, delete for blog posts
- ✅ **API Import System**: Import content from external APIs with one click
- ✅ **Data Transformation**: Intelligent conversion of products to blog posts
- ✅ **Duplicate Prevention**: Unique constraints on `source + external_id`
- ✅ **Draft System**: Imported posts saved as drafts for review
- ✅ **Status Management**: Toggle between draft and published states

### User Interface
- 📱 **Responsive Design**: Mobile-friendly Tailwind CSS interface
- 🎨 **Admin Panel**: Comprehensive post management dashboard
- 🌐 **Public Blog**: Clean reading experience for visitors
- 📊 **Visual Indicators**: Status badges, source tags, timestamps

### Technical Features
- 🔒 **Error Handling**: Comprehensive try-catch blocks with logging
- 🔄 **Interface Pattern**: Extensible importer architecture
- 📝 **Validation**: Server-side validation for all inputs
- 🎯 **Type Safety**: Proper type hinting and return types

---

## 🛠 Tech Stack

| Category | Technology | Purpose |
|----------|-----------|---------|
| **Backend** | Laravel 11.x | PHP framework for robust application structure |
| **Database** | MySQL 8.0+ | Relational database with ACID compliance |
| **Frontend** | Blade Templates | Server-side templating engine |
| **Styling** | Utility-first CSS framework via CDN |
| **HTTP Client** | Guzzle | Laravel's HTTP client for API requests |
| **ORM** | Eloquent | Laravel's elegant database abstraction |

---

## 🏗 Architecture

### Design Patterns Used

**1. Interface Segregation**

ImporterInterface
├── JsonPlaceholderImporter
├── FakeStoreImporter
└── [Future Importers...]

**2. Service Layer Pattern**

Controllers → Services → Models → Database

**3. Repository Pattern (Implicit)**

Eloquent ORM acts as repository layer

### Key Design Decisions

| Decision | Rationale |
|----------|-----------|
| **Service Layer** | Separates business logic from controllers, enabling reusability |
| **Interface-based Importers** | Allows easy addition of new API sources without modifying existing code |
| **Database Unique Constraint** | Prevents duplicates at the database level, not just application level |
| **Draft-first Approach** | Gives admins control over what gets published |
| **Separate Public/Admin Controllers** | Clear separation between public-facing and admin functionality |

---

## 🚀 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer 2.x
- MySQL 8.0 or higher
- Node.js & NPM (optional, for asset compilation)

### Step-by-Step Setup

1. **Clone the Repository**

https://github.com/milankakadiya/blogify-solution

cd blogify-solution

2. **Install Dependencies**

composer install

3. **Environment Configuration**

cp .env.example .env
php artisan key:generate

4. **Configure Database**

Edit `.env` file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogify
DB_USERNAME=root
DB_PASSWORD=your_password

5. **Create Database**

mysql -u root -p
CREATE DATABASE blogify;
exit

6. **Run Migrations**

php artisan migrate

7. **Start Development Server**

php artisan serve

8. **Access Application**
- Public Blog: http://localhost:8000
- Admin Panel: http://localhost:8000/admin/posts
- Import Page: http://localhost:8000/admin/imports

---

## 📖 Usage Guide

### Importing Content

1. Navigate to **Import** page from the navigation menu
2. Select an API source:
- **JSONPlaceholder**: Imports a random blog post
- **FakeStore**: Imports a random product (transformed to blog post)
3. Click **"🚀 Import Now"**
4. The system will:
- Fetch random data from the selected API
- Check for duplicates
- Transform data into blog post format
- Save as draft
- Show success/error message

### Managing Posts

**Create New Post**
1. Go to Admin Posts → Create New Post
2. Fill in title, content, and select status
3. Click "Create Post"

**Edit Post**
1. Click "Edit" on any post in the admin list
2. Modify fields as needed
3. Click "Update Post"

**Publish/Unpublish**
1. Edit the post
2. Change status dropdown to "Published" or "Draft"
3. Save changes

**Delete Post**
1. Click "Delete" on any post
2. Confirm deletion

### Viewing Public Blog

1. Navigate to the home page (/)
2. Browse published posts
3. Click "Read more" to view full post
4. Only published posts are visible to the public

---

## 🔌 API Integration

### Current Integrations

#### JSONPlaceholder API
- **Endpoint**: `https://jsonplaceholder.typicode.com/posts/{id}`
- **Method**: GET
- **IDs**: 1-100
- **Mapping**:
- `title` → `title`
- `body` → `content`
- `id` → `external_id`

#### FakeStore API
- **Endpoint**: `https://fakestoreapi.com/products/{id}`
- **Method**: GET
- **IDs**: 1-20
- **Transformation Logic**:
- `title` → `title`
- `description` → `content` (base)
- `price` → appended to `content`
- `category` → appended to `content`
- `id` → `external_id`

### Error Handling

The application implements comprehensive error handling at multiple levels:

**API Level**

try {
  $response = Http::timeout(10)->get($url);
  if ($response->successful()) {
      return $this->transformData($response->json());
  }

  Log::error('API request failed', [
      'status' => $response->status(),
      'body' => $response->body()
  ]);

  return null;
} catch (\Exception $e) {
  Log::error('Import exception', ['message' => $e->getMessage()]);
  return null;
}

**Database Level**
- Unique constraint prevents duplicate imports
- Try-catch for `QueryException` handling
- Graceful error messages to users

**User Feedback**
- Success/error messages displayed via flash sessions
- Validation errors shown inline on forms
- Descriptive error messages (not generic)

## 🔧 Adding New API Sources

### Step-by-Step Guide

**Example**: Adding a Dev.to API source

#### 1. Create Importer Class

touch app/Services/Importers/DevToImporter.php

`<?php

namespace App\Services\Importers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DevToImporter implements ImporterInterface
{
    private const BASE_URL = 'https://dev.to/api';

    public function import(): ?array
    {
        try {
            // Dev.to API returns an array of articles
            $response = Http::timeout(10)
                ->withHeaders([
                    'accept' => 'application/vnd.forem.api-v1+json'
                ])
                ->get(self::BASE_URL . '/articles', [
                    'per_page' => 1,
                    'page' => rand(1, 50) // Get random page
                ]);

            if ($response->successful()) {
                $articles = $response->json();

                // Check if we got any articles
                if (empty($articles)) {
                    Log::warning('Dev.to returned no articles');
                    return null;
                }

                // Get the first article from the array
                $article = $articles[0];

                return [
                    'title' => $article['title'] ?? 'Untitled Article',
                    'content' => $this->transformArticleContent($article),
                    'external_id' => (string)$article['id'],
                    'source' => $this->getSourceName(),
                ];
            }

            Log::error('Dev.to API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Dev.to import exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    private function transformArticleContent(array $article): string
    {
        $content = $article['description'] ?? '';

        // Add article metadata
        if (isset($article['tags']) && !empty($article['tags'])) {
            $content .= "\n\nTags: " . implode(', ', $article['tags']);
        }

        if (isset($article['published_at'])) {
            $content .= "\nOriginally Published: " . $article['published_at'];
        }

        if (isset($article['url'])) {
            $content .= "\n\nRead full article: " . $article['url'];
        }

        return $content;
    }

    public function getSourceName(): string
    {
        return 'devto';
    }
}`

Updated ImportController.php
File: app/Http/Controllers/Admin/ImportController.php

`<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PostImportService;
use App\Services\Importers\JsonPlaceholderImporter;
use App\Services\Importers\FakeStoreImporter;
use App\Services\Importers\DevToImporter;
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
            'source' => 'required|in:jsonplaceholder,fakestore,devto'
        ]);

        $importer = match($request->source) {
            'jsonplaceholder' => new JsonPlaceholderImporter(),
            'fakestore' => new FakeStoreImporter(),
            'devto' => new DevToImporter(),
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
}`

Updated Import View
File: resources/views/admin/imports/index.blade.php

Add this new radio button option (after the existing two):

`<label class="flex items-start p-5 border-2 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-400 transition">
    <input type="radio" name="source" value="devto" class="mt-1 mr-4" required>
    <div class="flex-1">
        <div class="font-semibold text-lg text-gray-800">Dev.to API</div>
        <div class="text-sm text-gray-600 mt-1">Import articles from Dev.to developer community</div>
        <div class="text-xs text-gray-500 mt-2">
            <strong>Endpoint:</strong> https://dev.to/api/articles
        </div>
    </div>
</label>`

Complete updated form section in resources/views/admin/imports/index.blade.php:

`<div class="space-y-4">
    <!-- JSONPlaceholder -->
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

    <!-- FakeStore -->
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

    <!-- Dev.to (NEW) -->
    <label class="flex items-start p-5 border-2 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-400 transition">
        <input type="radio" name="source" value="devto" class="mt-1 mr-4" required>
        <div class="flex-1">
            <div class="font-semibold text-lg text-gray-800">Dev.to API</div>
            <div class="text-sm text-gray-600 mt-1">Import articles from Dev.to developer community</div>
            <div class="text-xs text-gray-500 mt-2">
                <strong>Endpoint:</strong> https://dev.to/api/articles
            </div>
        </div>
    </label>
</div>`

Testing Commands

# 1. Create the new importer file

`touch app/Services/Importers/DevToImporter.php`

# 2. Copy the DevToImporter code above into the file

# 3. Update ImportController.php with the new match case

# 4. Update the import view with the new radio button

# 5. Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 6. Start server (if not running)
php artisan serve

# 7. Test the import
# Visit: http://localhost:8000/admin/imports
# Select "Dev.to API"
# Click "Import Now"
# Check if post is created successfully

# Verification Checklist
After implementing, verify:

1. File exists: app/Services/Importers/DevToImporter.php
2. Namespace correct: namespace App\Services\Importers;
3. Implements interface: implements ImporterInterface
4. Controller updated: DevToImporter added to match statement
5. Validation updated: 'devto' added to validation rule
6. View updated: New radio button for Dev.to
7. Import works: Successfully imports article from Dev.to
8. Draft created: Post saved with status='draft'
9. Duplicate prevention: Reimporting same article shows duplicate message
