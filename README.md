# 🔊 Echo — Laravel School Project

> *Le idee che risuonano.*

A feature-rich social platform built with Laravel, inspired by the official [Chirper tutorial](https://laravel.com/learn/getting-started-with-laravel/what-are-we-building). Extended with AI-powered moderation, semantic search, role-based access control and more.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Database Schema](#database-schema)
- [Getting Started](#getting-started)
- [Environment Variables](#environment-variables)
- [Author](#author)

---

## Overview

Echo is a school project that replicates and extends the base Laravel Chirper tutorial. Users can publish posts, comment, like, and interact with a daily topic set by an admin. The platform integrates OpenAI APIs for both **automatic content moderation** (before insertion) and **semantic search** (via text embeddings).

---

## Features

### 👥 Authentication & Roles
- Registration, login, logout via **Laravel Breeze**
- Two roles: `user` and `admin`
- Admins have exclusive access to privileged actions

### 📝 Posts
- Create, edit, delete posts
- Like/unlike system
- Automatic AI moderation before saving to DB
- Flagged posts are stored but hidden, with audit trail

### 💬 Comments
- Comment on individual posts
- Full CRUD for own comments
- AI moderation applied to comments as well

### 📌 Daily Topic (Admin only)
- Admin sets one topic per day
- Topic is pinned at the top of the feed
- Archive page showing past topics with associated posts

### 🤖 AI — Content Moderation (Pre-insertion)
- Every post/comment is validated through the **OpenAI Moderation API** before being saved
- Flagged content is blocked with a user-friendly message
- Moderation reason is stored for admin review

### 🔍 AI — Semantic Search
- Posts are indexed with **text embeddings** (OpenAI `text-embedding-3-small`)
- Search finds posts by *meaning*, not just keyword matching
- Similarity computed via cosine distance in PHP

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 11 |
| Authentication | Laravel Breeze |
| Frontend | Blade + Tailwind CSS |
| Database | MySQL / SQLite |
| AI — Moderation | OpenAI Moderation API |
| AI — Search | OpenAI Embeddings API |
| Queue (optional) | Laravel Queue (database driver) |

---

## Database Schema

```
users
 ├── id, name, email, password
 ├── role (enum: user, admin)
 └── timestamps

posts
 ├── id, user_id (FK)
 ├── body
 ├── is_flagged, flagged_reason
 └── timestamps

comments
 ├── id, post_id (FK), user_id (FK)
 ├── body
 ├── is_flagged
 └── timestamps

daily_topics
 ├── id, user_id (FK)
 ├── title, description
 ├── topic_date (unique)
 └── timestamps

post_likes
 ├── id, user_id (FK), post_id (FK)
 └── created_at
 (unique constraint on user_id + post_id)

embeddings
 ├── id, post_id (FK)
 ├── vector (JSON)
 └── created_at
```
## Getting Started

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL or SQLite
- An [OpenAI API key](https://platform.openai.com/api-keys)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/echo-social.git
cd echo-social

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install && npm run build

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure your .env (see section below)

# 7. Run migrations
php artisan migrate

# 8. (Optional) Seed the database with demo data
php artisan db:seed

# 9. Start the development server
php artisan serve
```

---

## Environment Variables

Add these to your `.env` file:

```env
APP_NAME=Echo
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=echo_social
DB_USERNAME=root
DB_PASSWORD=

# OpenAI — required for moderation and semantic search
OPENAI_API_KEY=sk-...
OPENAI_EMBEDDING_MODEL=text-embedding-3-small
```

---

## Author

**C. Squeo, A. Magaletti, M. Gile, S. Verroca**
School project — Panetti Pitagora Bari
Academic year 2025/2026

---

> Built with ❤️ and Laravel — *Echo, le idee che risuonano.*
