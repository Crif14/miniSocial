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
                <h1 class="text-xl font-bold text-white mb-1">Bentornato</h1>
                <p class="text-gray-500 text-sm mb-6">Accedi al tuo account Echo</p>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-4 text-green-400 text-sm" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1.5">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="echo-input" placeholder="tua@email.com" required autofocus>
                        @error('email')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-medium text-gray-400">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">
                                    Password dimenticata?
                                </a>
                            @endif
                        </div>
                        <input type="password" name="password"
                               class="echo-input" placeholder="••••••••" required>
                        @error('password')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember"
                               class="rounded bg-[#1e1e38] border-[#1e1e38]
                                      text-indigo-600 focus:ring-indigo-500">
                        <label for="remember" class="text-sm text-gray-400">
                            Ricordami
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="echo-btn w-full text-center mt-2">
                        Accedi
                    </button>
                </form>
            </div>

            {{-- Register link --}}
            <p class="text-center text-gray-500 text-sm mt-6">
                Non hai un account?
                <a href="{{ route('register') }}"
                   class="text-indigo-400 hover:text-indigo-300 transition-colors font-medium">
                    Registrati
                </a>
            </p>

        </div>
    </div>
</x-guest-layout>