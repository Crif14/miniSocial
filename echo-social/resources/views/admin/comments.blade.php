<x-app-layout>
    <!-- Contenitore principale centrato con larghezza massima -->
    <div class="max-w-3xl mx-auto">

        <!-- Header della pagina: Titolo e link di ritorno -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-display font-bold text-white">
                Moderazione Commenti
            </h1>
            <a href="{{ route('posts.index') }}" class="echo-btn-ghost text-sm">
                ← Torna al Feed
            </a>
        </div>

        <!-- Ciclo sui commenti in attesa; se vuoto, mostra il blocco-->
        @forelse($pendingComments as $comment)
            <!-- Card del singolo commento in revisione -->
            <div class="echo-card mb-4 border-yellow-600/30">

                <!-- Sezione Info: Avatar utente, nome e timestamp della segnalazione -->
                <div class="flex items-center gap-3 mb-3">
                    <!-- Avatar generato con l'iniziale del nome -->
                    <div class="rounded-full bg-gradient-to-br from-indigo-600
                                    to-purple-600 flex items-center justify-center
                                    text-white font-bold text-xs flex-shrink-0" style="width: 28px; height: 28px;">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">
                            {{ $comment->user->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Flaggato {{ $comment->flaggedAt->diffForHumans() }}
                            — elimina automaticamente il
                            {{ $comment->flaggedAt->addDays(7)->format('d/m/Y') }}
                        </p>
                    </div>
                    <!-- Badge di stato -->
                    <span class="ml-auto text-xs bg-yellow-600/20 text-yellow-400
                                     border border-yellow-600/30 px-2.5 py-0.5 rounded-full">
                        In revisione
                    </span>
                </div>

                <!-- Riferimento al contenuto del post originale-->
                <p class="text-xs text-gray-500 mb-1">
                    In risposta a: <span class="text-gray-400">{{ $comment->post->body }}</span>
                </p>

                <!-- Box contenente il testo del commento segnalato -->
                <div class="bg-[#0f0f1a] rounded-xl px-4 py-3 mb-4">
                    <p class="text-gray-200">{{ $comment->body }}</p>
                </div>

                <!-- Bottoni di azione per approvare o rifiutare il commento -->
                <div class="flex items-center gap-3">
                    <!-- Form per l'approvazione -->
                    <form method="POST" action="{{ route('comments.approve', $comment) }}">
                        @csrf
                        <button type="submit" class="bg-green-600/20 hover:bg-green-600/40 text-green-400
                                           border border-green-600/30 px-4 py-2 rounded-xl
                                           text-sm font-semibold transition-colors">
                            ✅ Approva
                        </button>
                    </form>

                    <!-- Form per il rifiuto-->
                    <form method="POST" action="{{ route('comments.reject', $comment) }}">
                        @csrf
                        <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400
                                           border border-red-600/30 px-4 py-2 rounded-xl
                                           text-sm font-semibold transition-colors">
                            ❌ Rifiuta
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <!-- Visualizzato quando non ci sono commenti da moderare -->
            <div class="text-center text-gray-600 py-16">
                <p class="text-lg">Nessun commento in attesa di revisione.</p>
                <p class="text-sm mt-1">Tutto pulito! 🎉</p>
            </div>
        @endforelse

    </div>
</x-app-layout>