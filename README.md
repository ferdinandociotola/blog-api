# 🔐 Blog API - RESTful API con Autenticazione

> API completa per gestione blog con autenticazione token, gestione posts, 
> categories, tags e comments. Progettata per essere consumata da frontend moderni 
> o app mobile.

![Laravel](https://img.shields.io/badge/Laravel-11-red)
![API](https://img.shields.io/badge/REST-API-green)
![Auth](https://img.shields.io/badge/Auth-Sanctum-blue)

## 🌐 API Online

**Base URL:** http://159.69.125.94/api

API deployata e funzionante. Testabile con Postman/cURL.

## 📡 Endpoint Principali

### Posts
```
GET    /api/posts           - Lista posts (paginata)
GET    /api/posts/{id}      - Dettaglio singolo post
POST   /api/posts           - Crea nuovo post (auth required)
PUT    /api/posts/{id}      - Modifica post (auth required)
DELETE /api/posts/{id}      - Elimina post (auth required)
```

### Autenticazione
```
POST   /api/register        - Registrazione utente
POST   /api/login           - Login (ritorna token)
POST   /api/logout          - Logout (invalida token)
```

### Categories & Tags
```
GET    /api/categories      - Lista categorie
GET    /api/tags            - Lista tags
```

## 🧪 Test con cURL

### Registrazione
```bash
curl -X POST http://159.69.125.94/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login
```bash
curl -X POST http://159.69.125.94/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

### Crea Post (con token)
```bash
curl -X POST http://159.69.125.94/api/posts \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Nuovo Post",
    "content": "Contenuto del post",
    "category_id": 1
  }'
```

## ⚙️ Funzionalità

### Core Features
- ✅ CRUD completo posts, categories, tags, comments
- ✅ Autenticazione token-based (Laravel Sanctum)
- ✅ Paginazione automatica risultati
- ✅ Ricerca e filtri avanzati
- ✅ API Resources per output consistente
- ✅ Validazione dati rigorosa

### Sicurezza
- 🔐 Token authentication
- 🔒 Rate limiting
- ✅ CORS configurato
- ✅ Validazione input completa

## 🛠️ Stack Tecnico

- **Framework:** Laravel 11
- **Auth:** Laravel Sanctum
- **Database:** MySQL 8.0
- **Server:** Nginx, Ubuntu 24.04

## 📋 Database Design
```
users (id, name, email, password)
  └── posts (id, user_id, title, slug, content, published_at)
        ├── categories (id, name, slug)
        ├── tags (id, name, slug)
        └── comments (id, post_id, user_id, content)
```

## 🚀 Installazione
```bash
git clone https://github.com/ferdinandociotola/blog-api.git
cd blog-api

composer install

cp .env.example .env
php artisan key:generate
php artisan migrate --seed

php artisan serve
```

## 📖 Documentazione API

Tutti gli endpoint ritornano JSON con struttura consistente:

### Success Response
```json
{
  "success": true,
  "data": { ... },
  "message": "Operazione completata"
}
```

### Error Response
```json
{
  "success": false,
  "message": "Errore descrittivo",
  "errors": { ... }
}
```

## 💡 Perché questo progetto?

Dimostra competenze essenziali per integrazioni aziendali moderne:

- API design professionale
- Autenticazione sicura
- Documentazione chiara
- Pronto per integrazione con app/frontend
- Scalabile e manutenibile

## 👨‍💻 Autore

**Ferdinando Ciotola**
- Email: nandociotola@gmail.com
- LinkedIn: [ferdinando-ciotola](https://linkedin.com/in/ferdinando-ciotola)

## 📄 Licenza

MIT License
