<x-app-layout>
    <div class="max-w-2xl mx-auto">

        <!-- TITOLO DELLA PAGINA -->
        <h1 class="text-2xl font-display font-bold text-white mb-6">
            Ricerca Semantica
        </h1>

        <!-- SEZIONE: FORM DI RICERCA -->
        <!-- Invia una richiesta GET alla rotta 'search.index'. 
             L'input mantiene il valore della ricerca corrente ($query) -->
        <div class="echo-card mb-6">
            <form method="GET" action="{{ route('search.index') }}" class="flex gap-3">
                <input type="text" name="q" value="{{ $query ?? '' }}"
                       class="echo-input"
                       placeholder="Cerca per significato... es: animali domestici">
                <button type="submit" class="echo-btn whitespace-nowrap">
                    Cerca
                </button>
            </form>
        </div>

        <!-- SEZIONE: GESTIONE ADMIN (VETTORIZZAZIONE) -->
        <!-- Solo gli amministratori vedono questo blocco. 
             Serve per convertire i testi dei post in vettori numerici (embeddings) via AI -->
        @if(auth()->user()->isAdmin())
            <div class="echo-card mb-6 border-indigo-600/30">
                <p class="text-sm text-gray-400 mb-3">
                    Genera gli embeddings per tutti i post senza vettore associato.
                </p>
                <form method="POST" action="{{ route('search.embeddings') }}">
                    @csrf
                    <button type="submit" class="echo-btn text-sm">
                        <!-- SVG Icona Robot (in sostituzione dell'emoji per coerenza) -->
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                        Genera Embeddings
                    </button>
                </form>
                <!-- Messaggio di successo-->
                @if(session('success'))
                    <p class="text-green-400 text-sm mt-2">{{ session('success') }}</p>
                @endif
            </div>
        @endif

        <!-- MESSAGGI DI ERRORE-->
        @if(session('warning'))
            <div class="bg-yellow-600/10 border border-yellow-600/30 rounded-xl px-4 py-3 mb-6">
                <p class="text-yellow-400 text-sm">{{ session('warning') }}</p>
            </div>
        @endif

        <!-- SEZIONE: RISULTATI DELLA RICERCA -->
        @if($query)
            <p class="text-gray-500 text-sm mb-4">
                Risultati per: <span class="text-indigo-400 font-semibold">{{ $query }}</span>
            </p>

            <!-- Ciclo sui post restituiti dal database-->
            @forelse($posts as $post)
                <div class="echo-card mb-4">
                    <!-- Header Post: Autore e Timestamp -->
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-600
                                    to-purple-600 flex items-center justify-center
                                    text-white font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">
                                {{ $post->user->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $post->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <!-- Contenuto del post trovato -->
                    <p class="text-gray-200 leading-relaxed">{{ $post->body }}</p>
                    
                    <div class="echo-divider"></div>

                    <!-- Footer Post: Statistiche rapide -->
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span>{{ $post->likes->count() }} like</span>
                        <span>{{ $post->comments->count() }} commenti</span>
                    </div>
                </div>
            @empty
                <!-- Visualizzato se la ricerca semantica non ha prodotto risultati -->
                <div class="text-center text-gray-600 py-16">
                    <p class="text-lg">Nessun risultato trovato.</p>
                    <p class="text-sm mt-1">Prova con parole diverse o concetti più ampi!</p>
                </div>
            @endforelse
        @endif

    </div>
</x-app-layout>