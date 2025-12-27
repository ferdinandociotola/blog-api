# Blog API

REST API completa per gestione blog con autenticazione token-based, paginazione e filtri avanzati.

## Stack Tecnologico

- Laravel 11
- PHP 8.3
- MySQL 8.0
- Laravel Sanctum (authentication)
- Nginx

## Features

- ✅ Autenticazione JWT con Laravel Sanctum
- ✅ CRUD completo per Posts
- ✅ Sistema Categories con relazioni many-to-many
- ✅ Comments system
- ✅ Pagination dinamica
- ✅ Search e filtri avanzati
- ✅ API Resources per output controllato

## Installazione

### 1. Clone repository
```bash
git clone https://github.com/ferdinandociotola/blog-api.git
cd blog-api
```

### 2. Installa dipendenze
```bash
composer install
```

### 3. Configura environment
```bash
cp .env.example .env
php artisan key:generate
```

Modifica `.env`:
```
DB_DATABASE=blog_api_local
DB_USERNAME=blog_user
DB_PASSWORD=tua_password
```

### 4. Database setup
```bash
php artisan migrate
```

### 5. Avvia server
```bash
php artisan serve
```

API disponibile su: `http://127.0.0.1:8000`

---

## Autenticazione

### Register
```bash
POST /api/register
```

**Body:**
```json
{
  "name": "Mario Rossi",
  "email": "mario@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "user": {
    "id": 1,
    "name": "Mario Rossi",
    "email": "mario@example.com"
  },
  "token": "1|abc123..."
}
```

### Login
```bash
POST /api/login
```

**Body:**
```json
{
  "email": "mario@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "user": {...},
  "token": "2|xyz789..."
}
```

### Logout
```bash
POST /api/logout
Authorization: Bearer {token}
```

---

## Endpoints

### Posts

#### GET /api/posts - Lista post (paginata)

**Parametri opzionali:**
- `per_page` - Risultati per pagina (default: 10)
- `page` - Numero pagina
- `search` - Cerca in title/content
- `status` - Filtra per status (published/draft)
- `category_id` - Filtra per categoria
- `order_by` - Campo ordinamento (default: created_at)
- `order_direction` - Direzione (asc/desc, default: desc)

**Esempi:**
```bash
# Tutti i post
GET /api/posts

# Search
GET /api/posts?search=Laravel

# Filtra published
GET /api/posts?status=published

# Pagination custom
GET /api/posts?per_page=5&page=2

# Combinazione filtri
GET /api/posts?search=PHP&status=published&per_page=10
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Primo Post",
      "slug": "primo-post",
      "content": "Contenuto...",
      "status": "published",
      "published_at": "2025-12-27 15:44:17",
      "author": {
        "id": 1,
        "name": "Mario Rossi"
      },
      "categories": [],
      "created_at": "2025-12-27 15:44:17"
    }
  ],
  "meta": {
    "total": 5,
    "current_page": 1,
    "last_page": 1,
    "per_page": 10
  },
  "links": {
    "first": "http://127.0.0.1:8000/api/posts?page=1",
    "last": "http://127.0.0.1:8000/api/posts?page=1",
    "prev": null,
    "next": null
  }
}
```

#### GET /api/posts/{id} - Dettaglio post
```bash
GET /api/posts/1
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "title": "Primo Post",
    "slug": "primo-post",
    "content": "Contenuto completo...",
    "status": "published",
    "published_at": "2025-12-27 15:44:17",
    "author": {
      "id": 1,
      "name": "Mario Rossi"
    },
    "categories": [],
    "created_at": "2025-12-27 15:44:17"
  }
}
```

#### POST /api/posts - Crea post (autenticato)
```bash
POST /api/posts
Authorization: Bearer {token}
```

**Body:**
```json
{
  "title": "Nuovo Post",
  "content": "Contenuto del post...",
  "status": "published",
  "category_id": 1
}
```

**Response:**
```json
{
  "data": {
    "id": 6,
    "title": "Nuovo Post",
    "slug": "nuovo-post",
    ...
  }
}
```

#### PUT /api/posts/{id} - Aggiorna post (autenticato)
```bash
PUT /api/posts/1
Authorization: Bearer {token}
```

**Body:**
```json
{
  "title": "Titolo Aggiornato",
  "content": "Contenuto aggiornato...",
  "status": "draft"
}
```

#### DELETE /api/posts/{id} - Elimina post (autenticato)
```bash
DELETE /api/posts/1
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "Post eliminato con successo"
}
```

---

### Categories

#### GET /api/categories - Lista categorie
```bash
GET /api/categories
```

#### GET /api/categories/{id} - Dettaglio categoria
```bash
GET /api/categories/1
```

---

### Comments

#### POST /api/posts/{post_id}/comments - Aggiungi comment (autenticato)
```bash
POST /api/posts/1/comments
Authorization: Bearer {token}
```

**Body:**
```json
{
  "content": "Ottimo post!"
}
```

#### DELETE /api/comments/{id} - Elimina comment (autenticato)
```bash
DELETE /api/comments/1
Authorization: Bearer {token}
```

---

## Database Schema

### users
- id
- name
- email
- password
- created_at
- updated_at

### posts
- id
- user_id (FK → users)
- title
- slug
- content
- status (published/draft)
- published_at
- created_at
- updated_at

### categories
- id
- name
- slug
- created_at
- updated_at

### category_post (pivot)
- category_id (FK → categories)
- post_id (FK → posts)

### comments
- id
- post_id (FK → posts)
- user_id (FK → users)
- content
- created_at
- updated_at

---

## Testing
```bash
# Test register
curl -X POST http://127.0.0.1:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@test.com","password":"password123","password_confirmation":"password123"}'

# Test login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@test.com","password":"password123"}'

# Test get posts
curl http://127.0.0.1:8000/api/posts?per_page=5

# Test create post (inserisci token)
curl -X POST http://127.0.0.1:8000/api/posts \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Post","content":"Contenuto","status":"published","category_id":1}'
```

---

## Autore

Ferdinando Ciotola - [GitHub](https://github.com/ferdinandociotola)

---

## License

MIT
