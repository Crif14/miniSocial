<x-app-layout>
    <div class="max-w-2xl mx-auto">

        <h1 class="text-2xl font-display font-bold text-white mb-6">
            Ricerca Semantica
        </h1>

        {{-- Form ricerca --}}
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

        {{-- Genera embeddings (solo admin) --}}
        @if(auth()->user()->isAdmin())
            <div class="echo-card mb-6 border-indigo-600/30">
                <p class="text-sm text-gray-400 mb-3">
                    Genera gli embeddings per tutti i post senza vettore associato.
                </p>
                <form method="POST" action="{{ route('search.embeddings') }}">
                    @csrf
                    <button type="submit" class="echo-btn text-sm">
                        🤖 Genera Embeddings
                    </button>
                </form>
                @if(session('success'))
                    <p class="text-green-400 text-sm mt-2">{{ session('success') }}</p>
                @endif
            </div>
        @endif

        {{-- Warning --}}
        @if(session('warning'))
            <div class="bg-yellow-600/10 border border-yellow-600/30 rounded-xl px-4 py-3 mb-6">
                <p class="text-yellow-400 text-sm">{{ session('warning') }}</p>
            </div>
        @endif

        {{-- Risultati --}}
        @if($query)
            <p class="text-gray-500 text-sm mb-4">
                Risultati per: <span class="text-indigo-400 font-semibold">{{ $query }}</span>
            </p>

            @forelse($posts as $post)
                <div class="echo-card mb-4">
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
                    <p class="text-gray-200 leading-relaxed">{{ $post->body }}</p>
                    <div class="echo-divider"></div>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span>{{ $post->likes->count() }} like</span>
                        <span>{{ $post->comments->count() }} commenti</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-600 py-16">
                    <p class="text-lg">Nessun risultato trovato.</p>
                    <p class="text-sm mt-1">Prova con parole diverse!</p>
                </div>
            @endforelse
        @endif

    </div>
</x-app-layout>