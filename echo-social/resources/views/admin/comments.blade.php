<x-app-layout>
    <div class="max-w-3xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-display font-bold text-white">
                Moderazione Commenti
            </h1>
            <a href="{{ route('posts.index') }}" class="echo-btn-ghost text-sm">
                ← Torna al Feed
            </a>
        </div>

        @forelse($pendingComments as $comment)
            <div class="echo-card mb-4 border-yellow-600/30">

                {{-- Info commento --}}
                <div class="flex items-center gap-3 mb-3">
                    <div class="rounded-full bg-gradient-to-br from-indigo-600
                                to-purple-600 flex items-center justify-center
                                text-white font-bold text-xs flex-shrink-0"
                         style="width: 28px; height: 28px;">
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
                    <span class="ml-auto text-xs bg-yellow-600/20 text-yellow-400
                                 border border-yellow-600/30 px-2.5 py-0.5 rounded-full">
                        In revisione
                    </span>
                </div>

                {{-- Post di riferimento --}}
                <p class="text-xs text-gray-500 mb-1">
                    In risposta a: <span class="text-gray-400">{{ $comment->post->body }}</span>
                </p>

                {{-- Testo commento flaggato --}}
                <div class="bg-[#0f0f1a] rounded-xl px-4 py-3 mb-4">
                    <p class="text-gray-200">{{ $comment->body }}</p>
                </div>

                {{-- Azioni --}}
                <div class="flex items-center gap-3">
                    <form method="POST"
                          action="{{ route('comments.approve', $comment) }}">
                        @csrf
                        <button type="submit"
                                class="bg-green-600/20 hover:bg-green-600/40 text-green-400
                                       border border-green-600/30 px-4 py-2 rounded-xl
                                       text-sm font-semibold transition-colors">
                            ✅ Approva
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('comments.reject', $comment) }}">
                        @csrf
                        <button type="submit"
                                class="bg-red-600/20 hover:bg-red-600/40 text-red-400
                                       border border-red-600/30 px-4 py-2 rounded-xl
                                       text-sm font-semibold transition-colors">
                            ❌ Rifiuta
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="text-center text-gray-600 py-16">
                <p class="text-lg">Nessun commento in attesa di revisione.</p>
                <p class="text-sm mt-1">Tutto pulito! 🎉</p>
            </div>
        @endforelse

    </div>
</x-app-layout>