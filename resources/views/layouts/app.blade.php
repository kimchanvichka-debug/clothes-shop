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
    </style>
    @livewireStyles
</head>
<body class="bg-white text-slate-900">

    <nav class="flex justify-between items-center px-6 py-4 border-b border-slate-50">
        <a href="/" class="flex items-end gap-3">
            <img src="{{ asset('logo.png') }}" alt="COZY." class="h-10 w-auto object-contain">
            <span class="fit-font text-[10px] font-bold uppercase tracking-[0.3em] mb-1">Cozy Collection</span>
        </a>
        <a href="/" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-black">Back to Shop</a>
    </nav>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>