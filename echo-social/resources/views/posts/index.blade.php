<x-app-layout>
    <div class="max-w-2xl mx-auto">

        <!-- SEZIONE: TOPIC DEL GIORNO -->
        <!-- Appare solo se esiste un topic attivo nel database -->
        @if($todayTopic)
            <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 border
                        border-indigo-600/30 rounded-2xl p-6 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                            </path>
                        </svg> Topic del giorno
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ $todayTopic->topicDate->format('d/m/Y') }}
                    </span>
                </div>
                <h2 class="text-xl font-bold text-white mb-1">
                    {{ $todayTopic->title }}
                </h2>
                @if($todayTopic->description)
                    <p class="text-gray-300 text-sm">{{ $todayTopic->description }}</p>
                @endif
            </div>
        @endif

        <!-- SEZIONE: AZIONI AMMINISTRATORE -->
        <!-- Controlla i permessi dell'utente per mostrare i tasti di gestione topic -->
        @if(auth()->user()->isAdmin())
            <div class="flex items-center justify-between mb-4">
                <span class="echo-badge-admin">Admin</span>
                <div class="flex gap-2">
                    @if(!$todayTopic)
                        <a href="{{ route('topics.create') }}" class="echo-btn text-sm">
                            + Topic del giorno
                        </a>
                    @endif
                    <a href="{{ route('topics.index') }}" class="echo-btn-ghost text-sm">
                        Storico topic
                    </a>
                </div>
            </div>
        @else
            <!-- Link storico visibile a tutti gli utenti -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('topics.index') }}" class="echo-btn-ghost text-sm">
                    Storico topic
                </a>
            </div>
        @endif

        <!-- SEZIONE: FORM NUOVO POST -->
        <!-- Card per permettere all'utente di pubblicare un nuovo contenuto -->
        <div class="echo-card mb-6">
            <form method="POST" action="{{ route('posts.store') }}">
                @csrf
                <textarea
                    name="body"
                    rows="3"
                    class="echo-input resize-none mb-3"
                    placeholder="Cosa stai pensando?"></textarea>
                <!-- Gestione errori di validazione per il body del post -->
                @error('body')
                    <p class="text-red-400 text-xs mb-2">{{ $message }}</p>
                @enderror
                <div class="flex justify-end">
                    <button type="submit" class="echo-btn">
                        Pubblica
                    </button>
                </div>
            </form>
        </div>

        <!-- Cicla attraverso i post passati dal controller; gestisce lo stato vuoto con-->
        @forelse ($posts as $post)
            <div class="echo-card mb-4">

                <!-- Header del Post: Avatar, Nome e Tempo trascorso -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <!-- Avatar circolare con iniziale del nome -->
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

                    <!-- Tasto Elimina: Visibile solo se sei l'autore o un admin -->
                    @if($post->userId === auth()->id() || auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-gray-600 hover:text-red-400
                                           transition-colors text-xs">
                                Elimina
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Testo principale del post -->
                <p class="text-gray-200 leading-relaxed">{{ $post->body }}</p>

                <!-- Footer del Post: Like e Contatore commenti -->
                <div class="echo-divider"></div>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">

                    <!-- Gestione Like-->
                    <form method="POST" action="{{ route('posts.like', $post) }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-1.5 transition-colors
                                       {{ $post->isLikedBy(auth()->user())
                                          ? 'text-indigo-400 hover:text-indigo-300'
                                          : 'text-gray-500 hover:text-indigo-400' }}">
                            <svg class="w-4 h-4"
                                 fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5
                                         4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            {{ $post->likes->count() }}
                        </button>
                    </form>

                    <span>{{ $post->comments->count() }} commenti</span>
                </div>

                <!-- LISTA COMMENTI SOTTO IL POST -->
                <!-- Filtra i commenti visibili (es. non segnalati/nascosti) -->
                @foreach($post->comments->filter(fn($c) => $c->isVisible()) as $comment)
                    <div class="flex items-start gap-3 mb-3">
                        <div class="rounded-full bg-gradient-to-br from-indigo-600
                                    to-purple-600 flex items-center justify-center
                                    text-white font-bold text-xs flex-shrink-0"
                             style="width: 28px; height: 28px;">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 bg-[#0f0f1a] rounded-xl px-4 py-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-white">
                                    {{ $comment->user->name }}
                                </span>
                                <!-- Cancellazione singolo commento -->
                                @if($comment->userId === auth()->id() || auth()->user()->isAdmin())
                                    <form method="POST"
                                          action="{{ route('comments.destroy', $comment) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-gray-600 hover:text-red-400
                                                       transition-colors text-xs">
                                            Elimina
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p class="text-gray-300 text-sm mt-0.5">{{ $comment->body }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- FORM PER AGGIUNGERE UN COMMENTO -->
                <form method="POST" action="{{ route('comments.store', $post) }}"
                      class="flex flex-col gap-2 mt-2">
                    @csrf
                    <div class="flex items-center gap-2">
                        <input type="text" name="body"
                               class="echo-input py-2 text-sm"
                               placeholder="Scrivi un commento...">
                        <button type="submit" class="echo-btn text-sm px-4 py-2 whitespace-nowrap">
                            Invia
                        </button>
                    </div>
                    <!-- Errore specifico per ogni post per non confondere i messaggi di validazione -->
                    @error('body_' . $post->id)
                        <p class="text-red-400 text-xs">{{ $message }}</p>
                    @enderror
                </form>

            </div>
        @empty
            <!-- Visualizzato se la collezione $posts è vuota -->
            <div class="text-center text-gray-600 py-16">
                <p class="text-lg">Nessun post ancora.</p>
                <p class="text-sm mt-1">Sii il primo a condividere qualcosa!</p>
            </div>
        @endforelse

    </div>
</x-app-layout>