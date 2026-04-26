<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COZY. | Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freehand&family=Inter:wght@400;700;900&family=JetBrains+Mono:wght@500&family=Kantumruy+Pro:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', 'Kantumruy Pro', sans-serif; }
        .fit-font { font-family: 'JetBrains Mono', monospace; }
        .khmer-font { font-family: 'Kantumruy Pro', sans-serif; }
        [x-cloak] { display: none !important; }

        @keyframes subtleZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
        .animate-living { animation: subtleZoom 20s infinite alternate ease-in-out; }
    </style>
    @livewireStyles
</head>
<body class="bg-white text-slate-900 antialiased">

    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             x-transition.duration.500ms
             class="fixed top-10 left-1/2 -translate-x-1/2 z-[100] w-full max-w-sm px-6">
            <div class="bg-black text-white p-6 rounded-[2rem] shadow-2xl border border-white/10 text-center ring-4 ring-orange-700/20">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500">Order Placed Successfully!</p>
                <p class="text-[9px] text-slate-400 mt-2 uppercase tracking-widest font-bold">We will contact you shortly.</p>
            </div>
        </div>
    @endif

    <nav class="grid grid-cols-3 items-center px-6 py-4 sticky top-0 bg-white/80 backdrop-blur-md z-50 border-b border-slate-50">
        <a href="/" class="flex items-end gap-3 group">
            <img src="{{ asset('logo.png') }}" alt="COZY." class="h-14 w-auto object-contain">
            <div class="hidden lg:flex flex-col border-l border-slate-200 pl-3 mb-1">
                <span class="fit-font text-[10px] font-bold uppercase tracking-[0.3em] text-slate-800 leading-none">Cozy Collection</span>
                <span class="fit-font text-[7px] font-medium tracking-[0.2em] uppercase text-slate-400 mt-1">Studio Edition / Est. 2026</span>
            </div>
        </a>

        <div class="hidden md:flex justify-center items-center gap-4 lg:gap-6">
            <a href="/" class="group flex flex-col items-center">
                <span class="text-[9px] font-bold uppercase tracking-[0.1em] text-black group-hover:text-orange-700 transition-colors">All</span>
                <span class="khmer-font text-[8px] text-slate-400 mt-0.5">ទាំងអស់</span>
            </a>
            @foreach(['Crop Top' => 'អាវខើច', 'Boxy Fit Tee' => 'អាវយឺតធំ', 'Dress' => 'រ៉ូប', 'Baggy Pants' => 'ខោបាវ', 'Bikini' => 'ឈុតហែលទឹក', 'Sets' => 'ឈុត'] as $slug => $kh)
                <a href="/{{ $slug }}" class="group flex flex-col items-center">
                    <span class="text-[9px] font-bold uppercase tracking-[0.1em] text-slate-600 group-hover:text-black">{{ $slug }}</span>
                    <span class="khmer-font text-[8px] text-slate-400 mt-0.5">{{ $kh }}</span>
                </a>
            @endforeach
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="/leeminka" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-black transition-colors">Account</a>
            <a href="/checkout"><livewire:cart-counter /></a>
        </div>
    </nav>

    <header class="px-4 mb-10" 
        x-data="{ 
            activeSlide: 1, 
            slides: [
                { id: 1, img: 'https://images.unsplash.com/photo-1552664199-fd31f7431a55?auto=format&fit=crop&q=80&w=2070', label: 'Cozy Collection', khmer: 'ឈុតសម្លៀកបំពាក់ទាន់សម័យ' },
                { id: 2, img: 'https://images.unsplash.com/photo-1562572159-4efc207f5aff?auto=format&fit=crop&q=80&w=2070', label: 'Cozy Collection', khmer: 'មានច្រេីនម៉ូត​ ច្រេីនពណ៏' },
                { id: 3, img: 'https://images.unsplash.com/photo-1529133039941-7f7273ca1479?auto=format&fit=crop&q=80&w=2070', label: 'Cozy Collection', khmer: 'ថតផ្ទាល់ 100%​' },
                { id: 4, img: 'https://images.unsplash.com/photo-1495385794356-15371f348c31?auto=format&fit=crop&q=80&w=2070', label: 'Cozy Collection', khmer: 'សូមកំុភ្លេចតាមដាន Website ពួកយេីង' }
            ],
            init() {
                setInterval(() => {
                    this.activeSlide = this.activeSlide === this.slides.length ? 1 : this.activeSlide + 1;
                }, 5000);
            }
        }">
        <div class="relative h-[65vh] rounded-[2.5rem] overflow-hidden bg-slate-200 shadow-inner">
            <template x-for="slide in slides" :key="slide.id">
                <div x-show="activeSlide === slide.id"
                     x-transition:enter="transition opacity duration-1000"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition opacity duration-1000"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0">
                    
                    <img :src="slide.img" class="w-full h-full object-cover animate-living">
                    
                    <div class="absolute inset-0 bg-black/30 flex flex-col justify-center items-center text-center px-4">
                        <h1 class="text-6xl md:text-8xl font-black text-white italic uppercase tracking-tighter drop-shadow-lg" x-text="slide.label"></h1>
                        <p class="khmer-font text-white/90 text-sm md:text-xl mt-2 tracking-widest uppercase font-bold" x-text="slide.khmer"></p>
                        <button class="mt-8 bg-white text-black px-10 py-4 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-orange-700 hover:text-white transition-all shadow-xl">Shop Collection</button>
                    </div>
                </div>
            </template>

            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2">
                <template x-for="slide in slides" :key="slide.id">
                    <div class="h-1 rounded-full transition-all duration-500"
                         :class="activeSlide === slide.id ? 'w-8 bg-white' : 'w-2 bg-white/40'"></div>
                </template>
            </div>
        </div>
    </header>

    <section class="px-4 pb-20">
        <h2 class="text-xs font-black uppercase tracking-[0.3em] mb-8 text-slate-400 text-center flex flex-col gap-2">
            <span>Collection</span>
            <span class="khmer-font font-normal tracking-normal text-slate-300">ផលិតផលទាំងអស់</span>
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 max-w-7xl mx-auto">
            @forelse($products as $product)
            <div class="group cursor-pointer">
                <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-slate-100 relative mb-3">
                    @if($product->image)
                        {{-- FIX: Checks if the image is a URL (Cloudinary) or a local path --}}
                        <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400 text-[10px] uppercase font-bold">No Image</div>
                    @endif
                    <livewire:add-to-cart-button :productId="$product->id" />
                </div>
                
                <div class="flex flex-col gap-0.5">
                    <h3 class="text-[10px] font-bold uppercase tracking-tight text-slate-900">{{ $product->name }}</h3>
                    @if($product->description)
                        <p class="text-[9px] text-slate-400 line-clamp-2 leading-relaxed lowercase italic">
                            {{ $product->description }}
                        </p>
                    @endif
                    <p class="text-[10px] font-black text-orange-700 tracking-widest mt-1">${{ number_format($product->price, 2) }}</p>
                </div>
            </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="fit-font text-slate-400 text-[10px] uppercase tracking-[0.3em]">No items in this category yet.</p>
                </div>
            @endforelse
        </div>
    </section>

    @livewireScripts
</body>
</html>