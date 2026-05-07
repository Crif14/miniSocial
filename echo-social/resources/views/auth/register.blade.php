<x-guest-layout>
    <div class="min-h-screen bg-[#0f0f1a] flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            {{-- Logo --}}
            <a href="/" class="flex items-center justify-center gap-2 mb-8">
                <svg class="w-8 h-8 text-indigo-500" viewBox="0 0 32 32" fill="none">
                    <path d="M2 16 Q7 6 12 16 Q17 26 22 16 Q27 6 30 16"
                          stroke="currentColor" stroke-width="2.5"
                          stroke-linecap="round" fill="none"/>
                </svg>
                <span class="font-display font-black text-2xl text-white">Echo</span>
            </a>

            {{-- Card --}}
            <div class="echo-card">
                <h1 class="text-xl font-bold text-white mb-1">Crea il tuo account</h1>
                <p class="text-gray-500 text-sm mb-6">Unisciti a Echo — è gratis</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    {{-- Nome --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1.5">
                            Nome
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="echo-input" placeholder="Il tuo nome" required autofocus>
                        @error('name')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1.5">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="echo-input" placeholder="tua@email.com" required>
                        @error('email')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1.5">
                            Password
                        </label>
                        <input type="password" name="password"
                               class="echo-input" placeholder="Min. 8 caratteri" required>
                        @error('password')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Conferma Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1.5">
                            Conferma Password
                        </label>
                        <input type="password" name="password_confirmation"
                               class="echo-input" placeholder="Ripeti la password" required>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="echo-btn w-full text-center mt-2">
                        Crea account
                    </button>
                </form>
            </div>

            {{-- Login link --}}
            <p class="text-center text-gray-500 text-sm mt-6">
                Hai già un account?
                <a href="{{ route('login') }}"
                   class="text-indigo-400 hover:text-indigo-300 transition-colors font-medium">
                    Accedi
                </a>
            </p>

        </div>
    </div>
</x-guest-layout>