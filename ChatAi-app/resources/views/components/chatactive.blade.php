            {{-- ACTIVE CHAT --}}
            <template x-if="messages.length > 0">
                <div class="flex-1 flex flex-col overflow-hidden">

                    <div
                        id="messages-container"
                        class="flex-1 overflow-y-auto py-8 px-4 lg:px-8"
                        style="scrollbar-width:thin;scrollbar-color:#333 transparent;"
                    >
                        <div class="max-w-3xl mx-auto flex flex-col gap-7">

                            <template x-for="(msg, index) in messages" :key="index">
                                <div class="flex w-full" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">

                                    {{-- USER bubble --}}
                                    <template x-if="msg.role === 'user'">
                                        <div class="bg-zinc-800 rounded-2xl px-4 py-2.5 text-[14px] text-gray-100 leading-relaxed whitespace-pre-wrap break-words" style="max-width:min(75%,560px)">
                                            <span x-text="msg.text"></span>
                                        </div>
                                    </template>

                                    {{-- AI response --}}
                                    <template x-if="msg.role !== 'user'">
                                        <div class="flex flex-col items-start gap-2.5 w-full">
                                            <div
                                                class="text-[14px] leading-[1.8] text-gray-100 w-full
                                                    [&_p]:mb-3 [&_p:last-child]:mb-0
                                                    [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:my-2 [&_ul]:space-y-1
                                                    [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:my-2 [&_ol]:space-y-1
                                                    [&_li]:text-gray-200
                                                    [&_strong]:text-white [&_strong]:font-semibold
                                                    [&_em]:text-gray-400 [&_em]:italic
                                                    [&_a]:text-blue-400 [&_a]:underline
                                                    [&_h1]:text-lg [&_h1]:font-semibold [&_h1]:text-white [&_h1]:mt-4 [&_h1]:mb-2
                                                    [&_h2]:text-base [&_h2]:font-semibold [&_h2]:text-white [&_h2]:mt-3 [&_h2]:mb-1.5
                                                    [&_h3]:text-sm [&_h3]:font-semibold [&_h3]:text-gray-200 [&_h3]:mt-2 [&_h3]:mb-1
                                                    [&_blockquote]:border-l-2 [&_blockquote]:border-white/20 [&_blockquote]:pl-4 [&_blockquote]:text-gray-400 [&_blockquote]:italic
                                                    [&_hr]:border-white/10 [&_hr]:my-4
                                                    [&_code:not(pre_code)]:bg-zinc-800 [&_code:not(pre_code)]:text-emerald-400 [&_code:not(pre_code)]:px-1.5 [&_code:not(pre_code)]:py-0.5 [&_code:not(pre_code)]:rounded [&_code:not(pre_code)]:text-[12px] [&_code:not(pre_code)]:font-mono
                                                    [&_pre]:bg-zinc-900 [&_pre]:border [&_pre]:border-zinc-700/60 [&_pre]:rounded-xl [&_pre]:p-4 [&_pre]:overflow-x-auto [&_pre]:my-3 [&_pre]:text-[12px] [&_pre]:leading-relaxed [&_pre]:text-gray-300"
                                                x-html="renderMarkdown(msg.text)"
                                            ></div>
                                            {{-- Action icons --}}
                                            <div class="flex items-center gap-0.5 -ml-1.5">
                                                <button @click="copyText(msg.text, $el)" title="Copy" class="p-1.5 text-gray-600 hover:text-gray-300 rounded-lg hover:bg-white/5 transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                </button>
                                                <button title="Good response" class="p-1.5 text-gray-600 hover:text-green-400 rounded-lg hover:bg-white/5 transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                                </button>
                                                <button title="Bad response" class="p-1.5 text-gray-600 hover:text-red-400 rounded-lg hover:bg-white/5 transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </template>

                            {{-- Typing dots --}}
                            <template x-if="loading">
                                <div class="flex justify-start">
                                    <div class="flex items-center gap-1.5 px-4 py-3 rounded-2xl bg-zinc-800/60">
                                        <span class="w-2 h-2 rounded-full bg-gray-400 animate-bounce" style="animation-delay:0ms"></span>
                                        <span class="w-2 h-2 rounded-full bg-gray-400 animate-bounce" style="animation-delay:150ms"></span>
                                        <span class="w-2 h-2 rounded-full bg-gray-400 animate-bounce" style="animation-delay:300ms"></span>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>

                    {{-- Pill input (active chat) --}}
                    <div class="shrink-0 px-4 pb-5 pt-2">
                        <div class="max-w-3xl mx-auto">
                            <div class="flex items-end gap-2 px-4 py-3 rounded-3xl border border-zinc-700 bg-zinc-900/90 focus-within:border-zinc-500 transition-all duration-200 shadow-xl">
                                <textarea
                                    x-model="userInput"
                                    @keydown.enter.prevent="handleEnter($event)"
                                    x-ref="textareaChat"
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
                            <p class="mt-1.5 text-center text-[9px] text-zinc-600 font-mono">↵ Send &nbsp;·&nbsp; Shift+↵ New line</p>
                        </div>
                    </div>

                </div>
            </template>