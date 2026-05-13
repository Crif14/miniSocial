<x-app-layout>
    <div class="max-w-2xl mx-auto">

        <!-- TITOLO DELLA PAGINA -->
        <div class="echo-card">
            <h1 class="text-xl font-bold text-white mb-1">Nuovo Topic del Giorno</h1>
            <p class="text-gray-500 text-sm mb-6">Imposta il topic di oggi per la community</p>

            <!-- FORM DI INVIO-->
            <form method="POST" action="{{ route('topics.store') }}" class="space-y-4">
                @csrf

                <!-- CAMPO TITOLO -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">
                        Titolo
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="echo-input" placeholder="Topic di oggi..." required>
                    
                    <!-- Validazione errore titolo -->
                    @error('title')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CAMPO DESCRIZIONE -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">
                        Descrizione
                    </label>
                    <textarea name="description" rows="3"
                              class="echo-input resize-none"
                              placeholder="Descrivi il topic...">{{ old('description') }}</textarea>
                    
                    <!-- Validazione errore descrizione -->
                    @error('description')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- AZIONI: Pulsanti per annullare o confermare l'invio -->
                <div class="flex justify-end gap-3">
                    <!-- Torna alla lista dei post senza salvare -->
                    <a href="{{ route('posts.index') }}" class="echo-btn-ghost">
                        Annulla
                    </a>
                    
                    <!-- Bottone di conferma invio -->
                    <button type="submit" class="echo-btn">
                        Pubblica Topic
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>