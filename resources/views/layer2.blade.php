<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Layer 2: AI_ANALYSIS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { cyber: { base: '#030712', panel: '#0f172a', border: '#1e293b', blue: '#3b82f6', text: '#e2e8f0', muted: '#64748b', green: '#10b981' }, void: '#010308', surface: '#050a14', grid: '#0a192f', neon: { blue: '#00f0ff', red: '#ff003c', green: '#00ff41', alert: '#ffb000' } }, fontFamily: { mono: ['"Share Tech Mono"', '"Courier New"', 'monospace'], } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #030712; border-left: 1px solid #1e293b; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; }
        .font-mono-tech { font-family: 'Share Tech Mono', monospace; }
        .font-sans-ui { font-family: 'Inter', sans-serif; }
        .pulse-text { animation: blink 2s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .crt::before { content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03)); z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none; opacity: 0.3; }
        .cyber-border { position: relative; border: 1px solid #00f0ff; box-shadow: 0 0 10px rgba(0, 240, 255, 0.1); }
        .cyber-border::before, .cyber-border::after { content: ''; position: absolute; width: 12px; height: 12px; border: 2px solid #00f0ff; pointer-events: none; }
        .cyber-border::before { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .cyber-border::after { bottom: -2px; right: -2px; border-left: none; border-top: none; }
        .glitch-text { position: relative; display: inline-block; }
        .glitch-text::before, .glitch-text::after { content: attr(data-text); position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.8; }
        .glitch-text::before { left: 2px; text-shadow: -1px 0 red; animation: glitch-anim-1 3s infinite linear alternate-reverse; }
        .glitch-text::after { left: -2px; text-shadow: -1px 0 blue; animation: glitch-anim-2 2s infinite linear alternate-reverse; }
        @keyframes glitch-anim-1 { 0% { clip-path: inset(20% 0 80% 0); } 100% { clip-path: inset(30% 0 20% 0); } }
        @keyframes glitch-anim-2 { 0% { clip-path: inset(10% 0 60% 0); } 100% { clip-path: inset(5% 0 80% 0); } }
    </style>
</head>
<body class="bg-cyber-base text-cyber-text font-sans-ui h-screen flex flex-col lg:flex-row overflow-hidden relative">

    <div class="lg:hidden flex justify-between items-center px-6 h-16 bg-cyber-base border-b border-cyber-border z-50 flex-shrink-0">
        <h1 class="text-xl font-black text-white tracking-widest drop-shadow-[0_0_8px_rgba(59,130,246,0.8)]">Q3T<span class="text-cyber-blue">-MLSFS</span></h1>
        <button onclick="document.getElementById('sidebar').classList.toggle('hidden')" class="border border-cyber-blue text-cyber-blue hover:bg-cyber-blue hover:text-white px-3 py-1 text-[10px] font-mono-tech tracking-widest uppercase transition-colors">
            [ MENU ]
        </button>
    </div>

    <aside id="sidebar" class="hidden lg:flex flex-col w-full lg:w-72 bg-cyber-base/95 lg:bg-cyber-base border-r border-cyber-border flex-shrink-0 z-40 absolute lg:relative h-[calc(100vh-4rem)] lg:h-screen top-16 lg:top-0 left-0 overflow-y-auto lg:overflow-visible transition-all">
        <div class="absolute right-0 top-0 bottom-0 w-[1px] bg-gradient-to-b from-transparent via-cyber-blue to-transparent opacity-50 hidden lg:block"></div>
        <div>
            <div class="h-24 hidden lg:flex flex-col justify-center px-6 border-b border-cyber-border relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyber-blue to-transparent"></div>
                <h1 class="text-3xl font-black text-white tracking-widest drop-shadow-[0_0_8px_rgba(59,130,246,0.8)]">Q3T<span class="text-cyber-blue">-MLSFS</span></h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[10px] text-cyber-blue font-mono-tech tracking-[0.2em] uppercase">SYS.CORE // V1.0.9</span>
                    <span class="h-1 w-1 bg-cyber-blue rounded-full pulse-text"></span>
                </div>
            </div>

            <div class="px-6 py-4 border-b border-cyber-border/50 bg-cyber-panel/30">
                <p class="text-[9px] text-cyber-muted font-mono-tech mb-2 tracking-widest uppercase">Hardware Diagnostics</p>
                <div class="space-y-2">
                    <div class="flex justify-between items-center text-xs font-mono-tech">
                        <span class="text-cyber-muted">CPU_LOAD</span>
                        <span class="text-cyber-green">14.2%</span>
                    </div>
                    <div class="w-full h-1 bg-cyber-border rounded overflow-hidden">
                        <div class="h-full bg-cyber-green w-[14%]"></div>
                    </div>
                    <div class="flex justify-between items-center text-xs font-mono-tech mt-1">
                        <span class="text-cyber-muted">MEM_ALLOC</span>
                        <span class="text-cyber-blue">3.8GB</span>
                    </div>
                    <div class="w-full h-1 bg-cyber-border rounded overflow-hidden">
                        <div class="h-full bg-cyber-blue w-[42%]"></div>
                    </div>
                </div>
            </div>

            <nav class="mt-4 flex flex-col gap-2 px-4">
                <a href="/dashboard" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all overflow-hidden flex items-center justify-between">
                    <span class="uppercase tracking-wider text-sm">Command Center</span>
                </a>
                
                <a href="{{ route('honeypot') }}" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all overflow-hidden flex items-center justify-between">
                    <span class="uppercase tracking-wider text-sm">Cowrie Honeypot</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">L_01</span>
                </a>
                
                <a href="{{ route('ai_analysis') }}" class="group relative px-4 py-3 bg-cyber-blue/10 border border-cyber-blue/30 text-white font-bold transition-all overflow-hidden flex items-center justify-between">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyber-blue"></div>
                    <span class="uppercase tracking-wider text-sm">AI Analysis</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">[ ACTV ]</span>
                </a>
                
                <a href="{{ route('webshell') }}" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all overflow-hidden flex items-center justify-between">
                    <span class="uppercase tracking-wider text-sm">Infra Matrix</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">L_03</span>
                </a>
                    <a href="{{ route('system_logs') }}" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all flex items-center justify-between">
    <span class="uppercase tracking-wider text-sm">System Logs</span>
    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">L_04</span>
</a>
            </nav>
        </div>
        <div class="p-4 border-t border-cyber-border bg-cyber-panel/50 relative mt-auto">
            <div class="absolute top-0 right-0 p-2 text-[8px] text-cyber-muted font-mono-tech">ID: ADM-001</div>
            <div class="flex items-center gap-3 px-2">
                <div class="h-10 w-10 rounded-sm bg-cyber-base border border-cyber-blue/50 flex items-center justify-center text-cyber-blue font-mono-tech text-lg shadow-[0_0_10px_rgba(59,130,246,0.3)]">A</div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Administrator</span>
                    <span class="text-[10px] text-cyber-green font-mono-tech pulse-text">AUTH_VERIFIED [OK]</span>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative z-10 overflow-hidden bg-void text-neon-blue font-mono crt">
        <div class="fixed inset-0 bg-[linear-gradient(to_right,#0a192f_1px,transparent_1px),linear-gradient(to_bottom,#0a192f_1px,transparent_1px)] bg-[size:40px_40px] opacity-20 z-[0] pointer-events-none"></div>

        <div class="flex-1 overflow-y-auto p-4 md:p-10 relative z-10 w-full max-w-[1500px] mx-auto">
            
            <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end border-b border-neon-blue/30 pb-4 md:pb-6 mb-6 md:mb-8 relative">
                <div class="absolute -bottom-[1px] left-0 w-1/4 h-[2px] bg-neon-blue shadow-[0_0_10px_#00f0ff]"></div>
                
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2 md:gap-3 text-[9px] md:text-[10px] tracking-[0.2em] md:tracking-[0.3em] opacity-60">
                        <span>AI_CORE: ACTIVE</span>
                        <span class="text-neon-green animate-pulse">● LINK_STABLE</span>
                    </div>
                    <h1 class="text-2xl md:text-4xl font-black uppercase tracking-widest text-white drop-shadow-[0_0_10px_rgba(0,240,255,0.5)] glitch-text" data-text="AI_ANALYSIS">
                        AI_ANALYSIS
                    </h1>
                    <p class="text-[9px] md:text-[10px] text-neon-blue/70 tracking-[0.1em] md:tracking-[0.2em]">L2_INTELLIGENCE_SUBSYSTEM // BEHAVIORAL_HEURISTICS_ENGINE</p>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8 mb-10">
                
                <div class="lg:col-span-8 space-y-6 md:space-y-8">
                    <div class="cyber-border bg-surface/80 p-1 backdrop-blur-sm">
                        <div class="px-4 md:px-5 py-2 md:py-3 border-b border-neon-blue/20 bg-grid/40 flex justify-between items-center">
                            <span class="text-[9px] md:text-[11px] font-bold tracking-[0.1em] md:tracking-[0.2em] uppercase">/// Behavioral_Briefing_Output</span>
                            <span class="text-[8px] md:text-[9px] opacity-50">REAL_TIME_STREAM</span>
                        </div>
                        <div class="p-4 md:p-6 bg-black/40 h-[200px] md:h-[250px] overflow-y-auto w-full">
                            <div class="text-[12px] md:text-[13px] leading-relaxed text-white/90 whitespace-pre-wrap break-words">
{{ $aiReport ?? 'System awaiting telemetry ingestion for behavioral synthesis...' }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface/40 border border-neon-blue/20 p-4">
                        <h3 class="text-[9px] md:text-[10px] font-bold text-neon-blue/70 tracking-[0.2em] uppercase mb-4">Ingested Telemetry Stream</h3>
                        <div class="max-h-40 overflow-y-auto pr-2 md:pr-4 space-y-2 text-[9px] md:text-[10px] w-full">
                            @forelse($logs ?? [] as $log)
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-2 border-b border-neon-blue/10 gap-1">
                                    <span class="break-all">[NODE: <span class="text-white">{{ $log->ip_address }}</span>] - TYPE: <span class="text-white">{{ $log->attack_type }}</span></span>
                                    <span class="font-bold {{ $log->risk_score >= 80 ? 'text-neon-red' : 'text-neon-green' }}">RISK_FACTOR: {{ $log->risk_score }}%</span>
                                </div>
                            @empty
                                <div class="italic opacity-30 uppercase tracking-widest text-center py-4">No incoming packets detected.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 flex flex-col w-full">
                    <div class="cyber-border bg-surface/80 flex flex-col h-[500px] lg:h-[700px] shadow-2xl backdrop-blur-sm">
                        
                        <div class="p-3 md:p-4 bg-neon-blue/10 border-b border-neon-blue/20 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-neon-blue animate-pulse shrink-0"></span>
                                <h3 class="text-[10px] md:text-[11px] font-bold tracking-[0.1em] md:tracking-[0.2em] uppercase truncate">Cognitive_Interface</h3>
                            </div>
                            <span class="text-[7px] md:text-[8px] opacity-40 uppercase shrink-0">v2.5_Neural</span>
                        </div>
                        
                        <div id="chat-box" class="flex-1 overflow-y-auto p-4 md:p-5 space-y-4 md:space-y-6 bg-black/20 text-[11px] md:text-[12px] leading-relaxed w-full">
                            <div class="flex flex-col gap-1.5">
                                <span class="text-[8px] md:text-[9px] font-bold text-neon-blue/60 tracking-widest uppercase">System_Broadcast:</span>
                                <div class="p-3 bg-neon-blue/5 border-l-2 border-neon-blue/30 italic text-neon-blue/80 break-words w-fit max-w-[90%]">
                                    SHIELD-AI Neural core stabilized. State your query, Administrator.
                                </div>
                            </div>
                        </div>

                        <div class="p-3 md:p-4 border-t border-neon-blue/20 bg-void shrink-0">
                            <div class="flex flex-col gap-2 md:gap-3">
                                <input type="text" id="user-input" 
                                    class="w-full bg-surface border border-neon-blue/30 rounded-none px-3 md:px-4 py-2 md:py-3 text-[11px] md:text-[12px] text-white focus:outline-none focus:border-neon-blue transition-all placeholder-neon-blue/20 shadow-inner" 
                                    placeholder="ENTER QUERY PARAMS...">
                                <button onclick="sendQuestion()" 
                                    class="w-full bg-neon-blue/10 border border-neon-blue text-neon-blue hover:bg-neon-blue hover:text-void py-2 md:py-3 text-[9px] md:text-[10px] font-bold tracking-[0.2em] md:tracking-[0.3em] uppercase transition-all shadow-lg">
                                    EXECUTE_UPLINK
                                </button>
                            </div>
                        </div>

                        <div class="px-3 md:px-4 py-2 bg-black border-t border-neon-blue/10 text-[7px] md:text-[8px] opacity-40 uppercase flex justify-between tracking-widest shrink-0">
                            <span>Terminal_Secure</span>
                            <span>OP: Administrator</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        async function sendQuestion() {
            const input = document.getElementById('user-input');
            const chatBox = document.getElementById('chat-box');
            if (!input.value) return;

            const userText = input.value;
            
            chatBox.innerHTML += `
                <div class="flex flex-col gap-1 text-right items-end w-full">
                    <span class="text-[8px] md:text-[9px] font-bold opacity-40 uppercase tracking-widest">Operator_Command:</span>
                    <div class="p-2 md:p-3 bg-white/5 border border-white/10 text-white inline-block shadow-sm break-words w-fit max-w-[90%] text-left">
                        ${userText}
                    </div>
                </div>
            `;
            
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;

            try {
                const response = await fetch("{{ route('ai.chat') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ question: userText })
                });
                
                const data = await response.json();

                chatBox.innerHTML += `
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-[8px] md:text-[9px] font-bold text-neon-blue tracking-widest uppercase">Neural_Response:</span>
                        <div class="p-2 md:p-3 bg-neon-blue/5 border-l-2 border-neon-blue/50 text-white/90 break-words w-fit max-w-[90%]">
                            ${data.answer}
                        </div>
                    </div>
                `;
            } catch (error) {
                chatBox.innerHTML += `
                    <div class="text-[8px] md:text-[9px] text-neon-red font-bold p-2 border border-neon-red/20 bg-neon-red/5 uppercase tracking-widest break-words w-full">
                        ERROR: Neural link severed. Connection failure.
                    </div>
                `;
            }
            
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        document.getElementById('user-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendQuestion();
        });
    </script>
</body>
</html>