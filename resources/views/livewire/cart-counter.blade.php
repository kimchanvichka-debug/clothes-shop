<div class="relative group cursor-pointer">
    <div class="bg-black text-white px-5 py-2.5 rounded-full flex items-center gap-3 hover:bg-orange-700 transition-all duration-500 shadow-lg border border-white/5">
        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Bag</span>
        
        <div class="w-[1px] h-3 bg-white/20"></div>

        <div class="flex items-center justify-center min-w-[12px]">
            @if($count > 0)
                <span class="text-[10px] font-black text-orange-400 animate-pulse">
                    {{ $count }}
                </span>
            @else
                <span class="text-[10px] font-black text-white/30">
                    0
                </span>
            @endif
        </div>
    </div>
    
    <div class="absolute inset-0 bg-orange-700/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
</div>