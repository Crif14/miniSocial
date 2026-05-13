<x-app-layout>
    <div class="max-w-2xl mx-auto">

        <h1 class="text-2xl font-display font-bold text-white mb-6">
            Storico Topic
        </h1>

        <!--Cicla tra tutti i topic salvati nel database -->
        @forelse ($topics as $topic)
            <div class="echo-card mb-4">
                
                <!-- Data-->
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-indigo-400 font-semibold">
                        {{ $topic->topicDate->format('d/m/Y') }}
                    </span>
                    
                    <!-- Verifica se il topic visualizzato è quello corrente -->
                    @if($topic->topicDate->isToday())
                        <span class="echo-badge-admin">Oggi</span>
                    @endif
                </div>

                <!-- Titolo e descrizione del topic -->
                <h2 class="text-lg font-bold text-white mb-1">
                    {{ $topic->title }}
                </h2>
                
                @if($topic->description)
                    <p class="text-gray-400 text-sm">{{ $topic->description }}</p>
                @endif

                <div class="echo-divider"></div>

                <!-- Informazioni sull'autore del topic -->
                <p class="text-xs text-gray-600">
                    Creato da {{ $topic->user->name }}
                </p>
            </div>
        @empty
            <!--  Visualizzato se non ci sono topic presenti nel sistema -->
            <div class="text-center text-gray-600 py-16">
                <p class="text-lg">Nessun topic ancora.</p>
            </div>
        @endforelse

    </div>
</x-app-layout>