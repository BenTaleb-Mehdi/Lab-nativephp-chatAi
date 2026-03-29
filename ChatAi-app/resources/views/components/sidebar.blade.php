    {{-- ══ SIDEBAR ══ --}}
    <aside
        x-show="showSidebar" x-cloak
        x-transition:enter="transition-transform duration-300 ease-out"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition-transform duration-200 ease-in"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 w-72 bg-zinc-950/95 border-r border-white/8 flex flex-col shrink-0 z-50 backdrop-blur-xl lg:static"
    >
        {{-- New Chat --}}
        <div class="p-4 border-b border-white/5">
            <button
                @click="newChat()"
                class="group flex items-center justify-center gap-2.5 w-full px-4 py-2.5 border border-white/10 hover:border-white/25 hover:bg-white/5 transition-all duration-200 rounded-lg text-[10px] uppercase tracking-[0.3em] text-gray-400 hover:text-white font-mono"
            >
                <svg class="w-3.5 h-3.5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Chat
            </button>
        </div>

        {{-- History --}}
        <div class="px-4 pt-4 pb-2">
            <span class="text-[8px] font-semibold text-gray-600 uppercase tracking-[0.4em] font-mono">Recent Chats</span>
        </div>

        <div class="flex-1 overflow-y-auto px-2 space-y-0.5" style="scrollbar-width:thin;scrollbar-color:#333 transparent;">
            <template x-if="sessions.length === 0">
                <p class="px-3 py-6 text-[11px] text-gray-700 text-center font-mono">No chats yet</p>
            </template>
            <template x-for="session in sessions" :key="session.id">
                <div
                    class="group relative flex items-center rounded-lg transition-all duration-150 cursor-pointer"
                    :class="currentSessionId === session.id
                        ? 'bg-white/8 border border-white/10'
                        : 'hover:bg-white/5 border border-transparent'"
                    @click="loadSession(session.id)"
                >
                    <div class="flex-1 px-3 py-2.5 min-w-0">
                        <p class="text-[12px] text-gray-300 truncate leading-snug" x-text="session.title"></p>
                        <p class="text-[10px] text-gray-600 mt-0.5 font-mono" x-text="formatDate(session.updatedAt)"></p>
                    </div>
                    <button
                        @click.stop="deleteSession(session.id)"
                        class="opacity-0 group-hover:opacity-100 shrink-0 mr-2 p-1.5 text-gray-600 hover:text-red-400 transition-all duration-150 rounded"
                        title="Delete"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        {{-- Footer --}}
        <div class="p-4 border-t border-white/5 flex items-center justify-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse" style="box-shadow:0 0 8px rgba(16,185,129,0.6)"></span>
            <span class="text-[8px] text-gray-600 uppercase tracking-[0.3em] font-mono">Connected</span>
        </div>
    </aside>