export function chatApp() {
    return {
        messages         : [],
        userInput        : '',
        loading          : false,
        showSidebar      : window.innerWidth >= 1024,
        sessions         : [],
        currentSessionId : null,

        // ⚠️ In Alpine v3, if an init() function exists, it is called automatically. 
        // You can remove x-init="init()" from your HTML wrapper to prevent double-firing.
        init() {
            this.loadSessions();
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) this.showSidebar = true;
            });
        },

        // ── localStorage ──────────────────────────────────────────
        loadSessions() {
            try {
                const storedData = JSON.parse(localStorage.getItem('mehdi_sessions'));
                // 1. FIX: Ensure data is ALWAYS an array to prevent fatal .sort() crashes
                this.sessions = Array.isArray(storedData) ? storedData : [];
                this.sessions.sort((a, b) => new Date(b.updatedAt) - new Date(a.updatedAt));
            } catch(e) { 
                this.sessions = []; 
            }
        },

        saveSessions() {
            try { localStorage.setItem('mehdi_sessions', JSON.stringify(this.sessions)); } catch(e){}
        },

        // ── session management ────────────────────────────────────
        newChat() {
            if (this.messages.length > 0) this.persistSession();
            this.messages          = [];
            this.currentSessionId  = null;
            this.userInput         = '';
            if (window.innerWidth < 1024) this.showSidebar = false;
            
            // 2. FIX: Use standard setTimeout to give the DOM enough time to swap <template> views
            setTimeout(() => { 
                const t = this.$refs.textarea; 
                if(t) t.focus(); 
            }, 50);
        },

        loadSession(id) {
            if (this.messages.length > 0 && this.currentSessionId !== id) this.persistSession();
            const s = this.sessions.find(s => s.id === id);
            if (!s) return;
            // 3. FIX: Add fallback empty array to prevent map/length errors on corrupted sessions
            this.messages          = JSON.parse(JSON.stringify(s.messages || []));
            this.currentSessionId  = id;
            if (window.innerWidth < 1024) this.showSidebar = false;
            this.$nextTick(() => this.scrollToBottom());
        },

        deleteSession(id) {
            this.sessions = this.sessions.filter(s => s.id !== id);
            this.saveSessions();
            if (this.currentSessionId === id) {
                this.messages = []; this.currentSessionId = null;
            }
        },

        persistSession() {
            if (this.messages.length === 0) return;
            const title = (this.messages.find(m => m.role === 'user')?.text || 'Chat').slice(0, 55);
            
            if (this.currentSessionId) {
                const idx = this.sessions.findIndex(s => s.id === this.currentSessionId);
                if (idx !== -1) {
                    this.sessions[idx].messages  = JSON.parse(JSON.stringify(this.messages));
                    this.sessions[idx].title     = title;
                    this.sessions[idx].updatedAt = new Date().toISOString();
                    
                    // 4. FIX: Force Alpine reactivity update. 
                    // Mutating an array element by index does not trigger the UI to re-render.
                    this.sessions = [...this.sessions];
                }
            } else {
                this.currentSessionId = 'sess_' + Date.now();
                this.sessions.unshift({
                    id        : this.currentSessionId,
                    title,
                    updatedAt : new Date().toISOString(),
                    messages  : JSON.parse(JSON.stringify(this.messages)),
                });
            }
            if (this.sessions.length > 50) this.sessions = this.sessions.slice(0, 50);
            this.saveSessions();
        },

        // ── send message ──────────────────────────────────────────
        async sendMessage() {
            const text = this.userInput.trim();
            if (!text || this.loading) return;

            this.messages.push({ role: 'user', text });
            this.userInput = '';
            this.loading   = true;

            this.$nextTick(() => {
                this.scrollToBottom();
                const ta = this.$refs.textareaChat || this.$refs.textarea;
                if (ta) { ta.style.height = 'auto'; ta.focus(); }
            });

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const res  = await fetch(window.CHAT_SEND_URL, {
                    method  : 'POST',
                    headers : { 'Content-Type':'application/json', 'X-CSRF-TOKEN':csrf, 'Accept':'application/json' },
                    body    : JSON.stringify({
                        message : text,
                        history : this.messages.slice(0, -1).map(m => ({ role: m.role, text: m.text })),
                    }),
                });
                if (!res.ok) throw new Error(`Server error ${res.status}`);
                const data  = await res.json();
                const reply = data.reply ?? data.message ?? data.text ?? data.response ?? '...';
                this.messages.push({ role: 'model', text: reply });
            } catch(err) {
                this.messages.push({ role: 'model', text: `⚠️ ${err.message}` });
            }

            this.loading = false;
            this.persistSession();
            this.$nextTick(() => this.scrollToBottom());
        },

        handleEnter(e) { if (!e.shiftKey) this.sendMessage(); },

        autoResize(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 144) + 'px';
        },

        scrollToBottom() {
            const el = document.getElementById('messages-container');
            if (el) el.scrollTop = el.scrollHeight;
        },

        async copyText(text, btn) {
            try {
                await navigator.clipboard.writeText(text);
                const orig = btn.innerHTML;
                btn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
                btn.classList.add('text-emerald-400');
                setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('text-emerald-400'); }, 1500);
            } catch(e) {}
        },

        formatDate(iso) {
            if (!iso) return '';
            const diff = Date.now() - new Date(iso);
            if (diff < 60000)     return 'Just now';
            if (diff < 3600000)   return Math.floor(diff/60000) + 'm ago';
            if (diff < 86400000)  return Math.floor(diff/3600000) + 'h ago';
            if (diff < 604800000) return Math.floor(diff/86400000) + 'd ago';
            return new Date(iso).toLocaleDateString();
        },

        renderMarkdown(text) {
            if (!text) return '';
            const esc = s => s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
            let h = text
                .replace(/```(\w*)\n?([\s\S]*?)```/g, (_, l, c) => `<pre><code class="language-${l}">${esc(c.trim())}</code></pre>`)
                .replace(/`([^`\n]+)`/g, '<code>$1</code>')
                .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.+?)\*/g,     '<em>$1</em>')
                .replace(/^### (.+)$/gm,   '<h3>$1</h3>')
                .replace(/^## (.+)$/gm,    '<h2>$1</h2>')
                .replace(/^# (.+)$/gm,     '<h1>$1</h1>')
                .replace(/^---+$/gm,       '<hr>')
                .replace(/^> (.+)$/gm,     '<blockquote>$1</blockquote>')
                .replace(/^\s*[-*] (.+)$/gm,'<li>$1</li>')
                .replace(/^\d+\. (.+)$/gm, '<li>$1</li>')
                .split(/\n{2,}/).map(p => {
                    if (/^<(h[1-3]|ul|ol|li|pre|blockquote|hr)/.test(p.trim())) return p;
                    return '<p>' + p.replace(/\n/g,'<br>') + '</p>';
                }).join('');
            h = h.replace(/(<li>[\s\S]*?<\/li>)+/g, m => `<ul>${m}</ul>`);
            return h;
        },
    };
}
