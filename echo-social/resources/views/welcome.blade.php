<!DOCTYPE html>
<html lang="it" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Echo — Le idee che risuonano</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0f0f1a] text-white min-h-screen flex flex-col">

    <!-- NAVBAR-->
    <nav class="w-full px-8 py-5 flex items-center justify-between border-b border-[#1e1e38]">
        <div class="flex items-center gap-2">
            <!-- Logo -->
            <svg class="w-8 h-8 text-indigo-500" viewBox="0 0 32 32" fill="none">
                <path d="M2 16 Q7 6 12 16 Q17 26 22 16 Q27 6 30 16"
                      stroke="currentColor" stroke-width="2.5"
                      stroke-linecap="round" fill="none"/>
            </svg>
            <span class="font-display font-black text-2xl tracking-tight">Echo</span>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Link accesso/Login-->
                <a href="{{ route('login') }}" class="echo-btn-ghost text-sm">Accedi</a>
                <a href="{{ route('register') }}" class="echo-btn text-sm">Registrati</a>
            
        </div>
    </nav>

    <!-- Area principale con messaggio di benvenuto e call to action -->
    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 py-24 relative overflow-hidden">

        <!-- EFFETTI DI SFONDO-->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                    w-[600px] h-[600px] bg-indigo-600/10 rounded-full blur-3xl pointer-events-none">
        </div>
        <div class="absolute top-1/3 left-1/3 w-[300px] h-[300px]
                    bg-purple-600/10 rounded-full blur-3xl pointer-events-none">
        </div>

        <!-- CONTENUTO CENTRALE -->
        <div class="relative z-10 max-w-3xl">

            <!--Piccolo annuncio animato -->
            <div class="inline-flex items-center gap-2 bg-indigo-600/10 border border-indigo-600/20
                        text-indigo-400 text-sm font-medium px-4 py-1.5 rounded-full mb-8">
                <span class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse"></span>
                Il social delle idee che contano
            </div>

            <!-- Titolo Principale-->
            <h1 class="font-display font-black text-6xl md:text-7xl leading-tight mb-6">
                Le idee che
                <span class="text-transparent bg-clip-text
                             bg-gradient-to-r from-indigo-400 to-purple-400">
                    risuonano.
                </span>
            </h1>

            <!-- Sottotitolo descrittivo -->
            <p class="text-gray-400 text-xl leading-relaxed mb-10 max-w-xl mx-auto">
                Echo è uno spazio dove le idee prendono vita, si diffondono
                e lasciano un segno. Condividi, commenta, connettiti.
            </p>

            <!--Pulsanti di registrazione e login -->
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <a href="{{ route('register') }}"
                   class="echo-btn text-base px-8 py-3">
                    Inizia ora — è gratis
                </a>
                <a href="{{ route('login') }}"
                   class="echo-btn-ghost text-base px-8 py-3">
                    Hai già un account?
                </a>
            </div>
        </div>
    </main>

    <!-- FOOTER: Note di chiusura e copyright -->
    <footer class="border-t border-[#1e1e38] py-6 text-center text-gray-600 text-sm">
        Echo — Le idee che risuonano &nbsp;·&nbsp; Progetto scolastico Laravel
    </footer>

</body>
</html>