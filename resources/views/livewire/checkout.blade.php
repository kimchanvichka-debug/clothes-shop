<div class="max-w-5xl mx-auto py-12 md:py-20 px-6 min-h-screen">
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-3xl font-black uppercase tracking-tighter italic">Your Bag</h1>
        <a href="/" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-black transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Continue Shopping
        </a>
    </div>

    <div class="grid lg:grid-cols-12 gap-16">
        <div class="lg:col-span-7">
            <div class="space-y-8">
                @forelse($products as $product)
                    <div class="flex items-center justify-between group animate-fade-in">
                        <div class="flex gap-6 items-center">
                            <div class="w-20 h-24 bg-slate-100 rounded-2xl overflow-hidden shadow-sm">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            </div>

                            <div>
                                <h3 class="text-[11px] font-black uppercase tracking-tight text-slate-900">{{ $product->name }}</h3>
                                
                                <div class="flex items-center gap-4 mt-3">
                                    <div class="flex items-center border border-slate-200 rounded-full px-2 py-1">
                                        <button wire:click="decrementQuantity({{ $product->id }})" class="p-1 hover:text-orange-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>

                                        <span class="text-[10px] font-black px-2 w-8 text-center text-slate-900">
                                            {{ $cartItems[$product->id] }}
                                        </span>

                                        <button wire:click="incrementQuantity({{ $product->id }})" class="p-1 hover:text-orange-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>

                                    <button wire:click="removeItem({{ $product->id }})" class="text-[9px] font-bold text-slate-300 hover:text-red-500 uppercase tracking-widest transition-colors">
                                        Remove
                                    </button>
                                </div>
                                
                                <p class="text-[10px] font-bold text-orange-700 mt-2">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>

                        <p class="text-[11px] font-black text-slate-900">
                            ${{ number_format($product->price * $cartItems[$product->id], 2) }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-16 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                        <p class="text-[10px] font-bold uppercase text-slate-400 tracking-[0.2em]">Your bag is empty</p>
                        <a href="/" class="inline-block mt-4 text-[10px] font-black uppercase text-orange-700 underline">Browse Products</a>
                    </div>
                @endforelse
            </div>

            @if($total > 0)
            <div class="mt-12 pt-8 border-t border-slate-100">
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Subtotal</p>
                        <p class="text-3xl font-black text-slate-900 italic tracking-tighter transition-all">
                            ${{ number_format($total, 2) }}
                        </p>
                    </div>
                    <p class="text-[9px] text-slate-400 uppercase font-medium">Free local pickup available</p>
                </div>
            </div>
            @endif
        </div>

        <div class="lg:col-span-5">
            <div class="bg-slate-950 text-white p-8 md:p-10 rounded-[2.5rem] shadow-2xl sticky top-24">
                <h2 class="text-xs font-black uppercase tracking-[0.2em] mb-8 text-center text-white/90">Shipping & Payment</h2>
                
                <form wire:submit.prevent="placeOrder" class="space-y-5">
                    <div class="space-y-3">
                        <input wire:model="name" type="text" placeholder="FULL NAME" 
                            class="w-full bg-white/5 border border-white/10 text-white p-4 rounded-2xl text-[10px] font-bold placeholder:text-slate-600 focus:outline-none focus:border-orange-700 transition-all uppercase">
                        
                        <input wire:model="phone" type="text" placeholder="PHONE NUMBER" 
                            class="w-full bg-white/5 border border-white/10 text-white p-4 rounded-2xl text-[10px] font-bold placeholder:text-slate-600 focus:outline-none focus:border-orange-700 transition-all uppercase">
                        
                        <textarea wire:model="address" placeholder="DELIVERY ADDRESS" 
                            class="w-full bg-white/5 border border-white/10 text-white p-4 rounded-2xl text-[10px] font-bold placeholder:text-slate-600 focus:outline-none focus:border-orange-700 transition-all uppercase min-h-[80px]"></textarea>
                    </div>

                    <div class="mt-8 bg-white text-black p-6 rounded-[2rem] text-center shadow-inner">
                        <span class="inline-block px-3 py-1 bg-orange-100 text-orange-700 text-[8px] font-black uppercase rounded-full mb-3">ABA KHQR</span>
                        <p class="text-[10px] font-black mb-4 uppercase tracking-tighter">Scan to Pay Now</p>
                        
                        <div class="relative inline-block mb-4">
                            <img src="{{ asset('aba-qr.png') }}" alt="ABA QR" class="w-44 h-44 mx-auto border border-slate-100 rounded-2xl shadow-sm">
                        </div>

                        <p class="text-[11px] font-black text-orange-700 mb-4 tracking-widest">${{ number_format($total, 2) }}</p>
                        
                        <div class="mt-2 text-left">
                            <label class="block text-[8px] font-black text-slate-400 uppercase mb-3 text-center">Upload Receipt Screenshot</label>
                            <input type="file" wire:model="screenshot" 
                                class="text-[9px] w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[9px] file:font-black file:bg-black file:text-white hover:file:bg-orange-700 transition-all cursor-pointer">
                            
                            <div wire:loading wire:target="screenshot" class="mt-3 text-center text-orange-700 text-[9px] font-bold italic animate-pulse">
                                Processing image...
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-500/20 border border-red-500/50 text-red-200 p-4 rounded-2xl text-[9px] font-bold uppercase tracking-widest">
                            <p class="mb-1 text-red-400">Please check the following:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <button type="submit" 
                        class="w-full bg-orange-700 text-white py-5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white hover:text-black transition-all duration-500 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Complete Purchase</span>
                        <span wire:loading>Please wait...</span>
                    </button>
                </form>

                <p class="text-[8px] text-center text-slate-500 mt-6 uppercase tracking-widest font-bold">Secure Payment Processing</p>
            </div>
        </div>
    </div>
</div>