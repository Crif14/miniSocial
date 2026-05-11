# 🔊 Echo — Laravel School Project

> *Le idee che risuonano.*

Piattaforma social sviluppata con Laravel, ispirata al tutorial ufficiale [Chirper](https://laravel.com/learn/getting-started-with-laravel/what-are-we-building). Estesa con moderazione AI, ricerca semantica, ruoli e molto altro.

---

## 📋 Indice

- [Overview](#overview)
- [Funzionalità](#funzionalità)
- [Tech Stack](#tech-stack)
- [Database](#database)
- [Installazione](#installazione)
- [Variabili d'ambiente](#variabili-dambiente)
- [Struttura del progetto](#struttura-del-progetto)
- [Autore](#autore)

---

## Overview

Echo è un progetto scolastico che replica ed estende il tutorial Laravel Chirper. Gli utenti possono pubblicare post, commentare, mettere like e interagire con un topic giornaliero impostato dall'admin. La piattaforma integra le API di OpenAI per la **moderazione automatica dei contenuti** (prima dell'inserimento) e la **ricerca semantica** tramite embeddings testuali.

L'ambiente di sviluppo è basato su **Docker** tramite Laravel Sail, con **phpMyAdmin** integrato per la gestione del database.

---

## Funzionalità

### 👥 Autenticazione e Ruoli
- Registrazione, login, logout tramite **Laravel Breeze**
- Due ruoli: `user` e `admin`
- Middleware `AdminMiddleware` per proteggere le route riservate
- Redirect automatico al feed se già loggato

### 📝 Post
- Pubblicazione e eliminazione post
- Sistema like/unlike
- Moderazione AI prima del salvataggio nel DB
- Post flaggati salvati ma nascosti, con audit trail

### 💬 Commenti
- Commenta i singoli post direttamente dal feed
- Eliminazione commento per autore o admin
- Moderazione AI applicata anche ai commenti

### 📌 Topic del Giorno (solo Admin)
- L'admin imposta un topic al giorno
- Il topic è fissato in cima al feed con stile dedicato
- Il bottone di creazione sparisce automaticamente se il topic è già stato creato oggi
- Pagina storico con tutti i topic passati

### 🤖 AI — Moderazione Contenuti (in arrivo)
- Ogni post/commento viene validato tramite **OpenAI Moderation API** prima del salvataggio
- I contenuti flaggati vengono bloccati con messaggio all'utente
- Il motivo della moderazione viene salvato per revisione admin

### 🔍 AI — Ricerca Semantica (in arrivo)
- I post vengono indicizzati con **text embeddings** (OpenAI `text-embedding-3-small`)
- La ricerca trova post per *significato*, non solo per keyword
- Similarità calcolata tramite distanza coseno in PHP

---

## Tech Stack

| Layer | Tecnologia |
|---|---|
| Framework | Laravel 13 |
| Autenticazione | Laravel Breeze |
| Frontend | Blade + Tailwind CSS |
| Database | MySQL 8.4 |
| Ambiente | Docker + Laravel Sail |
| DB Admin | phpMyAdmin |
| AI — Moderazione | OpenAI Moderation API |
| AI — Ricerca | OpenAI Embeddings API |

---

## Database

```
users
 ├── id, name, email, password
 ├── role (enum: user, admin)
 └── timestamps

posts
 ├── id, userId (FK)
 ├── body
 ├── isFlagged, flaggedReason
 └── timestamps

comments
 ├── id, postId (FK), userId (FK)
 ├── body, isFlagged
 └── timestamps

dailyTopics
 ├── id, userId (FK)
 ├── title, description
 ├── topicDate (unique)
 └── timestamps

postLikes
 ├── id, userId (FK), postId (FK)
 └── createdAt
 (vincolo unique su userId + postId)

embeddings
 ├── id, postId (FK)
 ├── vector (JSON)
 └── createdAt
```

### Relazioni

- `User` hasMany `Post`, `Comment`, `DailyTopic`
- `Post` hasMany `Comment` — hasOne `Embedding`
- `Post` belongsToMany `User` tramite `postLikes`

---

## Installazione

### Prerequisiti

- Docker Desktop
- WSL2 (su Windows)
- Git

### Avvio con Laravel Sail (WSL2/Mac/Linux)

```bash
# 1. Clona il repository
git clone https://github.com/your-username/echo-social.git
cd echo-social

# 2. Copia il file environment
cp .env.example .env

# 3. Avvia i container Docker
./vendor/bin/sail up -d

# 4. Installa le dipendenze PHP
./vendor/bin/sail composer install

# 5. Genera la chiave applicazione
./vendor/bin/sail artisan key:generate

# 6. Esegui le migrazioni
./vendor/bin/sail artisan migrate

# 7. Compila gli asset frontend
./vendor/bin/sail npm install && ./vendor/bin/sail npm run build
```

### Avvio con Docker Compose (Windows PowerShell)

```powershell
# 1. Clona il repository
git clone https://github.com/your-username/echo-social.git
cd echo-social

# 2. Copia il file environment
copy .env.example .env

# 3. Avvia i container Docker
docker compose up -d

# 4. Installa le dipendenze PHP
docker compose exec laravel.test composer install

# 5. Genera la chiave applicazione
docker compose exec laravel.test php artisan key:generate

# 6. Esegui le migrazioni
docker compose exec laravel.test php artisan migrate

# 7. Compila gli asset frontend
docker compose exec laravel.test npm install
docker compose exec laravel.test npm run build
```
Poi vai su:
- **Sito:** `http://localhost`
- **phpMyAdmin:** `http://localhost:8081`

### Primo Admin

```bash
./vendor/bin/sail artisan tinker
$user = App\Models\User::where('email', 'tua@email.com')->first();
$user->role = 'admin';
$user->save();
```

---

## Variabili d'ambiente

env
APP_NAME=Echo
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password

# Groq — moderazione contenuti
GROQ_API_KEY=gsk_la-tua-chiave
GROQ_MODEL=llama-3.3-70b-versatile

# HuggingFace — ricerca semantica con embeddings
HUGGINGFACE_API_KEY=hf_la-tua-chiave
HUGGINGFACE_EMBEDDING_MODEL=sentence-transformers/all-MiniLM-L6-v2


---

## Autore

**[C. Squeo, A. Magaletti, M. Gile, S. Verroca]**
Progetto scolastico — [Panetti Pitagora]
Anno scolastico 2025/2026

---

> Built with ❤️ and Laravel — *Echo, le idee che risuonano.*
