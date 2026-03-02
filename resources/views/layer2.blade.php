<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Layer 2: Neural Analysis Core</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        void: '#010308',
                        surface: '#050a14',
                        grid: '#0a192f',
                        neon: { blue: '#00f0ff', red: '#ff003c', green: '#00ff41', alert: '#ffb000' }
                    }
                }
            }
        }
    </script>
    <style>
        /* CRT & Grid Sync with Layer 1 */
        body { background-color: #010308; margin: 0; overflow-x: hidden; font-family: 'Share Tech Mono', monospace; color: #00f0ff; }
        .crt::before {
            content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
            z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none; opacity: 0.3;
        }

        /* Cyber Borders Sync with Layer 1 */
        .cyber-border {
            position: relative; border: 1px solid #00f0ff;
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.1);
        }
        .cyber-border::before, .cyber-border::after {
            content: ''; position: absolute; width: 12px; height: 12px; border: 2px solid #00f0ff; pointer-events: none;
        }
        .cyber-border::before { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .cyber-border::after { bottom: -2px; right: -2px; border-left: none; border-top: none; }

        /* Glitch Effect Sync */
        .glitch-text { position: relative; display: inline-block; }
        .glitch-text::before, .glitch-text::after {
            content: attr(data-text); position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.8;
        }
        .glitch-text::before { left: 2px; text-shadow: -1px 0 red; animation: glitch-anim-1 3s infinite linear alternate-reverse; }
        .glitch-text::after { left: -2px; text-shadow: -1px 0 blue; animation: glitch-anim-2 2s infinite linear alternate-reverse; }
        @keyframes glitch-anim-1 { 0% { clip-path: inset(20% 0 80% 0); } 100% { clip-path: inset(30% 0 20% 0); } }
        @keyframes glitch-anim-2 { 0% { clip-path: inset(10% 0 60% 0); } 100% { clip-path: inset(5% 0 80% 0); } }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #010308; }
        ::-webkit-scrollbar-thumb { background: #00f0ff; }
    </style>
</head>
<body class="crt">
    <div class="fixed inset-0 bg-[linear-gradient(to_right,#0a192f_1px,transparent_1px),linear-gradient(to_bottom,#0a192f_1px,transparent_1px)] bg-[size:40px_40px] opacity-20 z-[-1]"></div>

    <div class="max-w-[1500px] mx-auto p-6 md:p-10 relative z-10">
        
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end border-b border-neon-blue/30 pb-6 mb-8 relative">
            <div class="absolute -bottom-[1px] left-0 w-1/4 h-[2px] bg-neon-blue shadow-[0_0_10px_#00f0ff]"></div>
            
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-3 text-[10px] tracking-[0.3em] opacity-60">
                    <span>AI_CORE: ACTIVE</span>
                    <span class="text-neon-green animate-pulse">● LINK_STABLE</span>
                </div>
                <h1 class="text-4xl font-black uppercase tracking-widest text-white drop-shadow-[0_0_10px_rgba(0,240,255,0.5)] glitch-text" data-text="NEURAL_ANALYSIS_CORE">
                    NEURAL_ANALYSIS_CORE
                </h1>
                <p class="text-[10px] text-neon-blue/70 tracking-[0.2em]">L2_INTELLIGENCE_SUBSYSTEM // BEHAVIORAL_HEURISTICS_ENGINE</p>
            </div>

            <a href="/dashboard" class="mt-6 lg:mt-0 border border-neon-blue px-6 py-2 hover:bg-neon-blue hover:text-void transition-all duration-300 font-bold tracking-[0.2em] text-xs flex items-center gap-2">
                RETURN_TO_COMMAND
            </a>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8 space-y-8">
                <div class="cyber-border bg-surface/80 p-1 backdrop-blur-sm">
                    <div class="px-5 py-3 border-b border-neon-blue/20 bg-grid/40 flex justify-between items-center">
                        <span class="text-[11px] font-bold tracking-[0.2em] uppercase">/// Behavioral_Briefing_Output</span>
                        <span class="text-[9px] opacity-50">REAL_TIME_STREAM</span>
                    </div>
                    <div class="p-8 bg-black/40 min-h-[400px]">
                        <div class="text-[13px] leading-relaxed text-white/90 whitespace-pre-wrap">
{{ $aiReport ?? 'System awaiting telemetry ingestion for behavioral synthesis...' }}
                        </div>
                    </div>
                </div>

                <div class="bg-surface/40 border border-neon-blue/20 p-4">
                    <h3 class="text-[10px] font-bold text-neon-blue/70 tracking-[0.2em] uppercase mb-4">Ingested Telemetry Stream</h3>
                    <div class="max-h-40 overflow-y-auto pr-4 space-y-2 text-[10px]">
                        @forelse($logs as $log)
                            <div class="flex justify-between items-center py-2 border-b border-neon-blue/10">
                                <span>[NODE: <span class="text-white">{{ $log->ip_address }}</span>] - TYPE: <span class="text-white">{{ $log->attack_type }}</span></span>
                                <span class="font-bold {{ $log->risk_score >= 80 ? 'text-neon-red' : 'text-neon-green' }}">RISK_FACTOR: {{ $log->risk_score }}%</span>
                            </div>
                        @empty
                            <div class="italic opacity-30 uppercase tracking-widest text-center py-4">No incoming packets detected.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 flex flex-col">
                <div class="cyber-border bg-surface/80 flex flex-col h-[700px] shadow-2xl backdrop-blur-sm">
                    
                    <div class="p-4 bg-neon-blue/10 border-b border-neon-blue/20 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-neon-blue animate-pulse"></span>
                            <h3 class="text-[11px] font-bold tracking-[0.2em] uppercase">Cognitive_Interface</h3>
                        </div>
                        <span class="text-[8px] opacity-40 uppercase">v2.5_Neural</span>
                    </div>
                    
                    <div id="chat-box" class="flex-1 overflow-y-auto p-5 space-y-6 bg-black/20 text-[12px] leading-relaxed">
                        <div class="flex flex-col gap-1.5">
                            <span class="text-[9px] font-bold text-neon-blue/60 tracking-widest uppercase">System_Broadcast:</span>
                            <div class="p-3 bg-neon-blue/5 border-l-2 border-neon-blue/30 italic text-neon-blue/80">
                                SHIELD-AI Neural core stabilized. State your query, Administrator.
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-t border-neon-blue/20 bg-void">
                        <div class="flex flex-col gap-3">
                            <input type="text" id="user-input" 
                                class="w-full bg-surface border border-neon-blue/30 rounded-none px-4 py-3 text-[12px] text-white focus:outline-none focus:border-neon-blue transition-all placeholder-neon-blue/20 shadow-inner" 
                                placeholder="ENTER QUERY PARAMS...">
                            <button onclick="sendQuestion()" 
                                class="w-full bg-neon-blue/10 border border-neon-blue text-neon-blue hover:bg-neon-blue hover:text-void py-3 text-[10px] font-bold tracking-[0.3em] uppercase transition-all shadow-lg">
                                EXECUTE_UPLINK
                            </button>
                        </div>
                    </div>

                    <div class="px-4 py-2 bg-black border-t border-neon-blue/10 text-[8px] opacity-40 uppercase flex justify-between tracking-widest">
                        <span>Terminal_Secure</span>
                        <span>OP: Administrator</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        async function sendQuestion() {
            const input = document.getElementById('user-input');
            const chatBox = document.getElementById('chat-box');
            if (!input.value) return;

            const userText = input.value;
            
            chatBox.innerHTML += `
                <div class="flex flex-col gap-1 text-right">
                    <span class="text-[9px] font-bold opacity-40 uppercase tracking-widest">Operator_Command:</span>
                    <div class="p-3 bg-white/5 border border-white/10 text-white inline-block self-end shadow-sm">
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
                    <div class="flex flex-col gap-1.5">
                        <span class="text-[9px] font-bold text-neon-blue tracking-widest uppercase">Neural_Response:</span>
                        <div class="p-3 bg-neon-blue/5 border-l-2 border-neon-blue/50 text-white/90">
                            ${data.answer}
                        </div>
                    </div>
                `;
            } catch (error) {
                chatBox.innerHTML += `
                    <div class="text-[9px] text-neon-red font-bold p-2 border border-neon-red/20 bg-neon-red/5 uppercase tracking-widest">
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