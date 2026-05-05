---

# 🚀 Chirper AI - Laravel Evolution Project

**Chirper AI** è un'applicazione web basata su Laravel che evolve il concept originale della guida ufficiale "[Learn Laravel](https://laravel.com/learn/getting-started-with-laravel/what-are-we-building)". Il progetto trasforma un semplice microblogging in una piattaforma social moderna, arricchita da sistemi di moderazione automatica e ricerca semantica basata su Intelligenza Artificiale.

## 🌟 Caratteristiche Principali

Il progetto implementa le funzionalità core di Laravel (CRUD, Auth, Routing) e si spinge oltre con feature avanzate:

### 🛠 Funzionalità Base (Derived from Laravel Starter)
* **Autenticazione completa:** Registrazione e gestione profili utenti.
* **Micro-blogging:** Creazione, visualizzazione e modifica di brevi post (Chirps).
* **Custom UI:** Interfaccia personalizzata con un design moderno (basata su Tailwind CSS).

### 🚀 Feature Evolute
* **Commenti Multi-livello:** Possibilità per gli utenti di commentare i singoli post per favorire l'interazione.
* **Ricerca Semantica AI:** Sistema di ricerca che non si limita alle keyword, ma comprende il contesto (es. cercare post per orientamento politico o sentiment), utilizzando vettorizzazione e AI (es. OpenAI Embeddings o simili).
* **Daily Topic (Admin Only):** Ogni giorno viene creato un tema di discussione ufficiale, fissato in alto nella timeline. Solo gli amministratori hanno il privilegio di definire il topic giornaliero.
* **Archivio Storico:** Sezione dedicata alla consultazione dei topic passati e dei relativi flussi di discussione.
* **Moderazione Automatica:** Sistema di analisi del testo in tempo reale che blocca o segnala contenuti che violano la netiquette prima ancora della pubblicazione sul database.

## 🛠 Tech Stack
* **Framework:** Laravel 11
* **Frontend:** Blade / Livewire (o Vue/Inertia a seconda della tua scelta)
* **Database:** MySQL / PostgreSQL
* **Styling:** Tailwind CSS
* **AI Integration:** (Specifica qui se usi OpenAI API, LangChain o altri modelli per la ricerca semantica e moderazione).

## 📥 Installazione

1.  **Clona il repository:**
    ```bash
    git clone https://github.com/tuo-username/chirper-ai.git
    cd chirper-ai
    ```
2.  **Installa le dipendenze:**
    ```bash
    composer install
    npm install && npm run build
    ```
3.  **Configurazione ambiente:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Configura il database** nel file `.env` e avvia le migrazioni (inclusi i seed per l'admin):
    ```bash
    php artisan migrate --seed
    ```
5.  **Avvia il server:**
    ```bash
    php artisan serve
    ```

---

*Creato da C. Squeo,  A. Magaletti, M. Gile e S. Verroca come progetto di approfondimento sullo sviluppo web moderno.*
