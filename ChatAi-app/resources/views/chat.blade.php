@extends('layouts.app')

@section('content')
<script>
    window.CHAT_SEND_URL = "{{ route('chat.send') }}";
</script>
{{-- ══ STARFIELD ══ --}}
<canvas id="starfield" class="fixed inset-0 w-full h-full pointer-events-none" style="z-index:0;"></canvas>

{{-- ══ APP ══ --}}
<div
    x-data="chatApp()"
  
    class="relative flex h-screen overflow-hidden text-gray-300"
    style="z-index:10;"
>
    {{-- Mobile overlay --}}
    <div
        x-show="showSidebar" x-cloak
        @click="showSidebar = false"
        x-transition:enter="transition-opacity duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 lg:hidden"
    ></div>

    <x-sidebar />

    {{-- ══ MAIN ══ --}}
    <main class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
        <x-navbar />
        {{-- ══ CONTENT AREA ══ --}}
        <div class="flex-1 overflow-hidden flex flex-col">

            {{-- EMPTY STATE --}}
            <template x-if="messages.length === 0">
                <div class="flex-1 flex flex-col items-center justify-center gap-8 px-6">
                    <div class="flex flex-col items-center gap-4 text-center">
                        <div class="w-px h-14 bg-gradient-to-b from-transparent via-white/20 to-transparent"></div>
                        <div>
                            <h1 class="text-sm font-light text-white tracking-[0.6em] uppercase font-mono">Mehdi.AI</h1>
                            <p class="text-[10px] text-gray-600 tracking-[0.2em] mt-1.5 font-mono">How can I help you today?</p>
                        </div>
                        <div class="w-px h-6 bg-gradient-to-b from-white/10 to-transparent"></div>
                    </div>

                    <div class="w-full max-w-2xl">
                        <div class="flex items-end gap-2 px-4 py-3 rounded-3xl border border-zinc-700 bg-zinc-900/90 focus-within:border-zinc-500 transition-all duration-200 shadow-xl">
                            <textarea
                                x-model="userInput"
                                @keydown.enter.prevent="handleEnter($event)"
                                x-ref="textarea"
                                rows="1"
                                placeholder="Ask anything..."
                                class="flex-1 bg-transparent resize-none outline-none text-[14px] text-gray-100 placeholder-zinc-500 py-0.5 max-h-36 leading-relaxed"
                                x-init="$watch('userInput', () => autoResize($el))"
                            ></textarea>
                            <button
                                @click="sendMessage()"
                                :disabled="!userInput.trim() || loading"
                                class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-200"
                                :class="userInput.trim() && !loading ? 'bg-white text-black hover:bg-gray-200 hover:scale-105' : 'bg-zinc-700 text-zinc-500 cursor-not-allowed'"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-center text-[9px] text-zinc-600 font-mono">↵ Send &nbsp;·&nbsp; Shift+↵ New line</p>
                    </div>
                </div>
            </template>

            <x-chatactive />

        </div>     
    </main>
</div>


@endsection