# Blog API - Laravel REST API

Sistema completo di gestione blog con autenticazione, relazioni complesse e test automatici.

![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-blue?logo=php)
![Tests](https://img.shields.io/badge/Tests-10%20passed-brightgreen)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)

## 🚀 Demo Live

- **API Base:** http://159.69.125.94/api
- **Endpoint Posts:** http://159.69.125.94/api/posts
- **GitHub:** https://github.com/ferdinandociotola/blog-api

## ✨ Features

### Core
- ✅ REST API completa (CRUD Posts, Categories, Comments)
- ✅ Autenticazione token (Laravel Sanctum)
- ✅ Relazioni database complesse (1-N, N-N)
- ✅ Paginazione, ricerca, filtri
- ✅ API Resources per risposte strutturate

### Sicurezza
- ✅ Controllo ownership (solo owner modifica/cancella)
- ✅ Validazione input su tutti endpoint
- ✅ Token authentication per endpoint protetti
- ✅ Test autorizzazione completi

### Testing
- ✅ 10 test automatici PHPUnit
- ✅ Feature tests (CRUD completo)
- ✅ Validazione tests (422 errors)
- ✅ Authorization tests (403 forbidden)
- ✅ 25 assertions - 0.4s execution

## 📚 Endpoints

### Public
```
GET    /api/posts              # Lista posts (paginata, ricerca, filtri)
GET    /api/posts/{id}         # Dettaglio post
GET    /api/categories         # Lista categorie
POST   /api/register           # Registrazione utente
POST   /api/login              # Login (restituisce token)
```

### Protected (require token)
```
POST   /api/posts              # Crea post
PUT    /api/posts/{id}         # Aggiorna post (solo owner)
DELETE /api/posts/{id}         # Cancella post (solo owner)
POST   /api/posts/{id}/comments # Aggiungi comment
POST   /api/logout             # Logout
```

## 🛠️ Tech Stack

- **Framework:** Laravel 11
- **Database:** MySQL 8.0
- **Authentication:** Laravel Sanctum (token-based)
- **Testing:** PHPUnit 11.5
- **Server:** Nginx, Ubuntu 24.04
- **Tools:** Git, Composer, Artisan

## 📦 Installazione
```bash
# Clone repository
git clone https://github.com/ferdinandociotola/blog-api
cd blog-api

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Start server
php artisan serve
```

## 🧪 Testing
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=test_can_create_post

# With coverage
php artisan test --coverage
```

**Test Coverage:**
- ✅ Authentication (login, validation)
- ✅ CRUD operations (create, read, update, delete)
- ✅ Authorization (ownership checks)
- ✅ Validation errors (422 responses)

## 📖 API Examples

### Login
```bash
curl -X POST http://159.69.125.94/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "password"}'
```

### Create Post (authenticated)
```bash
curl -X POST http://159.69.125.94/api/posts \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title": "My Post", "content": "Content here", "status": "published"}'
```

### Get Posts (with filters)
```bash
curl "http://159.69.125.94/api/posts?search=laravel&category_id=1&per_page=20"
```

## 🗄️ Database Schema

- **users** (id, name, email, password)
- **posts** (id, user_id, title, slug, content, status, published_at)
- **categories** (id, name, slug)
- **comments** (id, user_id, post_id, content)
- **category_post** (pivot: post_id, category_id)

## 👨‍💻 Author

**Ferdinando Ciotola**
- GitHub: [@ferdinandociotola](https://github.com/ferdinandociotola)
- LinkedIn: [ferdinando-ciotola](https://linkedin.com/in/ferdinando-ciotola)
- Email: nandociotola@gmail.com

## 📄 License

Open source - Educational/Portfolio project
