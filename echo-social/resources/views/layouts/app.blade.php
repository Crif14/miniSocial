<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Echo') }} — {{ $title ?? 'Feed' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#0f0f1a]">

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-50 bg-[#0f0f1a]/80 backdrop-blur-md border-b border-[#1e1e38]">
        <div class="max-w-4xl mx-auto px-4 flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                <svg class="w-8 h-8 text-indigo-500 group-hover:text-indigo-400 transition-colors"
                     viewBox="0 0 32 32" fill="none">
                    <path d="M2 16 Q7 6 12 16 Q17 26 22 16 Q27 6 30 16"
                          stroke="currentColor" stroke-width="2.5"
                          stroke-linecap="round" fill="none"/>
                </svg>
                <span class="font-display font-black text-2xl tracking-tight text-white">
                    Echo
                </span>
            </a>

            {{-- Nav links --}}
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="text-gray-400 hover:text-white px-3 py-2 rounded-lg
                              hover:bg-[#1e1e38] transition-colors text-sm font-medium">
                        Feed
                    </a>

                    {{-- Avatar + Dropdown --}}
                    <div class="relative ml-2" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-600
                                       to-purple-600 flex items-center justify-center text-white
                                       font-bold text-sm ring-2 ring-indigo-600/30
                                       hover:ring-indigo-500/60 transition-all">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </button>
                        <div x-show="open" @click.outside="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-[#16162a] border border-[#1e1e38]
                                    rounded-xl shadow-xl shadow-black/50 py-1 z-50">
                            <div class="px-4 py-2 border-b border-[#1e1e38]">
                                <p class="text-sm font-semibold text-white truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-2 text-sm text-gray-300
                                      hover:text-white hover:bg-[#1e1e38] transition-colors">
                                Profilo
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-400
                                               hover:text-red-300 hover:bg-[#1e1e38] transition-colors">
                                    Esci
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="echo-btn-ghost text-sm">Accedi</a>
                    <a href="{{ route('register') }}" class="echo-btn text-sm">Registrati</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- CONTENUTO --}}
    <main class="max-w-4xl mx-auto px-4 py-8">
        {{ $slot }}
    </main>

</body>
</html>