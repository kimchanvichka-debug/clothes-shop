<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COZY. | Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=JetBrains+Mono:wght@500&family=Kantumruy+Pro:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', 'Kantumruy Pro', sans-serif; }
        .fit-font { font-family: 'JetBrains Mono', monospace; }
        .khmer-font { font-family: 'Kantumruy Pro', sans-serif; }
        
        /* Smooth fade for mobile transitions */
        [x-cloak] { display: none !important; }
    </style>
    @livewireStyles
</head>
<body class="bg-white text-slate-900 antialiased">

    <nav class="flex justify-between items-center px-6 py-4 border-b border-slate-100 sticky top-0 bg-white/80 backdrop-blur-md z-50">
        <a href="/" class="flex items-end gap-3 group">
            <img src="{{ asset('logo.png') }}" alt="COZY." class="h-10 w-auto object-contain group-hover:opacity-80 transition-opacity">
            <span class="fit-font text-[10px] font-bold uppercase tracking-[0.3em] mb-1 hidden sm:block">Cozy Collection</span>
        </a>
        <a href="/" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-black transition-colors">
            Back to Shop
        </a>
    </nav>

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="py-8 px-6 border-t border-slate-50 text-center">
        <p class="text-[10px] uppercase tracking-widest text-slate-300">© 2026 Cozy Studio - Secure Checkout</p>
    </footer>

    @livewireScripts
</body>
</html>