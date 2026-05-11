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
        <div class="max-w-5xl mx-auto px-4 flex items-center justify-between h-16 gap-4">

            {{-- Logo --}}
            <a href="{{ route('posts.index') }}" class="flex items-center gap-2 group flex-shrink-0">
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

            {{-- Barra di ricerca --}}
            @auth
                <form method="GET" action="{{ route('search.index') }}"
                      class="w-64">
                    <div class="relative">
                        <input type="text" name="q"
                               value="{{ request('q') }}"
                               placeholder="Cerca..."
                               class="w-full bg-[#1e1e38] border border-[#1e1e38]
                                      focus:border-indigo-500 rounded-xl px-4 py-2 pr-10
                                      text-gray-100 placeholder-gray-500 text-sm
                                      outline-none transition-colors duration-200
                                      focus:ring-2 focus:ring-indigo-500/20">
                        <button type="submit"
                                class="absolute right-3 top-1/2 -translate-y-1/2
                                       text-gray-500 hover:text-indigo-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            @endauth

            {{-- Nav links --}}
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('posts.index') }}"
                       class="px-3 py-2 rounded-lg transition-colors text-sm
                              {{ request()->routeIs('posts.index')
                                 ? 'text-white font-bold bg-[#1e1e38]'
                                 : 'text-gray-400 hover:text-white font-medium hover:bg-[#1e1e38]' }}">
                        Feed
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.comments') }}"
                           class="px-3 py-2 rounded-lg transition-colors text-sm
                                  {{ request()->routeIs('admin.comments')
                                     ? 'text-white font-bold bg-indigo-600/30 border border-indigo-600/50'
                                     : 'echo-badge-admin hover:bg-indigo-600/30' }}">
                            Moderazione
                        </a>
                    @endif

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
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('topics.create') }}"
                                   class="block px-4 py-2 text-sm text-gray-300
                                          hover:text-white hover:bg-[#1e1e38] transition-colors">
                                    + Topic del giorno
                                </a>
                                <a href="{{ route('topics.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-300
                                          hover:text-white hover:bg-[#1e1e38] transition-colors">
                                    Storico topic
                                </a>
                            @endif
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