        {{-- Nav --}}
        <nav class="w-full flex items-center justify-between px-4 lg:px-6 py-3.5 shrink-0 border-b border-white/8 bg-black/80 backdrop-blur-md z">
            <div class="flex items-center gap-3">
                <button @click="showSidebar = !showSidebar" class="p-2 text-gray-500 hover:text-white transition-colors rounded-lg hover:bg-white/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <span class="text-[10px] font-bold tracking-[0.4em] uppercase text-gray-400 font-mono">Mehdi.AI</span>
                <span class="hidden sm:inline text-[9px] text-gray-700 font-mono">// Core_v1.0</span>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="hidden sm:inline text-[8px] text-gray-600 uppercase tracking-widest font-mono">Online</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" style="box-shadow:0 0 10px rgba(16,185,129,0.5)"></span>
            </div>
        </nav>