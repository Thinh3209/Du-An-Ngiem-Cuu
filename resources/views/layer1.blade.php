<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Threat Containment Matrix (L1)</title>
    
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
        .crt::before { content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06)); z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none; }
        .scanline { width: 100%; height: 10px; position: fixed; z-index: 9999; background: linear-gradient(to bottom, rgba(0,240,255,0), rgba(0,240,255,0.1) 50%, rgba(0,240,255,0)); opacity: 0.1; animation: scan 6s linear infinite; pointer-events: none; }
        @keyframes scan { 0% { top: -10%; } 100% { top: 110%; } }
        .cyber-border { position: relative; border: 1px solid #00f0ff; box-shadow: 0 0 10px rgba(0, 240, 255, 0.1), inset 0 0 20px rgba(0, 240, 255, 0.05); }
        .cyber-border::before, .cyber-border::after { content: ''; position: absolute; width: 15px; height: 15px; border: 2px solid #00f0ff; pointer-events: none; }
        .cyber-border::before { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .cyber-border::after { bottom: -2px; right: -2px; border-left: none; border-top: none; }
        .glitch-text { position: relative; display: inline-block; }
        .glitch-text::before, .glitch-text::after { content: attr(data-text); position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.8; }
        .glitch-text::before { left: 2px; text-shadow: -1px 0 red; animation: glitch-anim-1 2s infinite linear alternate-reverse; }
        .glitch-text::after { left: -2px; text-shadow: -1px 0 blue; animation: glitch-anim-2 3s infinite linear alternate-reverse; }
        @keyframes glitch-anim-1 { 0% { clip-path: inset(20% 0 80% 0); } 20% { clip-path: inset(60% 0 10% 0); } 40% { clip-path: inset(40% 0 50% 0); } 60% { clip-path: inset(80% 0 5% 0); } 80% { clip-path: inset(10% 0 70% 0); } 100% { clip-path: inset(30% 0 20% 0); } }
        @keyframes glitch-anim-2 { 0% { clip-path: inset(10% 0 60% 0); } 20% { clip-path: inset(30% 0 20% 0); } 40% { clip-path: inset(70% 0 10% 0); } 60% { clip-path: inset(20% 0 50% 0); } 80% { clip-path: inset(50% 0 30% 0); } 100% { clip-path: inset(5% 0 80% 0); } }
        .hex-stream { writing-mode: vertical-rl; text-orientation: mixed; white-space: nowrap; overflow: hidden; background: -webkit-linear-gradient(top, rgba(0,240,255,0), rgba(0,240,255,0.8), rgba(0,240,255,0)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; animation: flow 10s linear infinite; }
        @keyframes flow { 0% { transform: translateY(-100%); } 100% { transform: translateY(100%); } }
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
                
                <a href="{{ route('honeypot') }}" class="group relative px-4 py-3 bg-cyber-blue/10 border border-cyber-blue/30 text-white font-bold transition-all overflow-hidden flex items-center justify-between">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyber-blue"></div>
                    <span class="uppercase tracking-wider text-sm">Cowrie Honeypot</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">[ ACTV ]</span>
                </a>
                
                <a href="{{ route('ai_analysis') }}" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all overflow-hidden flex items-center justify-between">
                    <span class="uppercase tracking-wider text-sm">AI Analysis</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">L_02</span>
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
        <div class="scanline hidden lg:block"></div>
        <div class="fixed inset-0 bg-[linear-gradient(to_right,#0a192f_1px,transparent_1px),linear-gradient(to_bottom,#0a192f_1px,transparent_1px)] bg-[size:40px_40px] opacity-20 z-[0] pointer-events-none"></div>
        <div class="fixed left-72 top-0 bottom-0 w-4 hidden lg:flex flex-col justify-between z-[0] opacity-30 text-[8px] tracking-widest pointer-events-none">
            <div class="hex-stream">0xFA 0x11 0x4C 0x89 0x2B 0xAA 0xFF 0x01 0x9C</div>
            <div class="hex-stream" style="animation-delay: -5s; color: #ff003c;">0xDE 0xAD 0xBE 0xEF 0x40 0x40 0x00</div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-10 relative z-10 w-full max-w-[1400px] mx-auto">
            <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end border-b border-neon-blue/30 pb-6 mb-8 relative gap-4">
                <div class="absolute -bottom-[1px] left-0 w-1/3 h-[2px] bg-neon-blue shadow-[0_0_10px_#00f0ff]"></div>
                
                <div class="flex flex-col gap-2">
                    <div class="flex flex-wrap items-center gap-2 md:gap-4 text-[10px] md:text-xs tracking-[0.2em] md:tracking-[0.3em] opacity-70">
                        <span>SYS.OP: NORMAL</span>
                        <span class="text-neon-red animate-pulse">■ REC</span>
                        <span>NET_SYNC: 99.9%</span>
                    </div>
                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-black uppercase tracking-widest text-white drop-shadow-[0_0_15px_rgba(0,240,255,0.6)] glitch-text" data-text="ISOLATION_MATRIX">
                        ISOLATION_MATRIX
                    </h1>
                    <p class="text-[10px] md:text-xs text-neon-blue/70 tracking-[0.1em] md:tracking-[0.2em]">L1_HONEYPOT_INFRASTRUCTURE // COWRIE_ENGINE_ACTIVE</p>
                </div>

                <div class="flex flex-col items-end gap-3 w-full lg:w-auto">
                    <div class="border border-neon-blue/40 px-3 py-1 bg-neon-blue/5 flex gap-4 text-[10px] tracking-widest w-full justify-between lg:w-auto">
                        <span>PORT: 2222</span>
                        <span class="text-neon-green">STATUS: LISTENING</span>
                    </div>
                </div>
            </header>

            <div class="mb-4 text-[10px] md:text-xs tracking-widest uppercase opacity-60 flex justify-between">
                <span>/// Captured_Adversary_Nodes</span>
                <span>Total: {{ count($sessions ?? []) }} Entities</span>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 md:gap-6 mb-10">
                @forelse($sessions ?? [] as $session)
                <div class="cyber-border bg-surface/80 p-4 md:p-5 flex flex-col gap-4 relative group hover:bg-grid/40 transition-colors backdrop-blur-sm w-full">
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start border-b border-neon-blue/20 pb-3 gap-2">
                        <div>
                            <div class="text-[9px] text-neon-blue/50 tracking-widest">ENTITY_ID: {{ $session->id }}</div>
                            <div class="text-sm md:text-xl font-bold text-neon-red drop-shadow-[0_0_8px_rgba(255,0,60,0.4)] flex items-center gap-2 mt-1 break-all">
                                <span class="text-[10px] md:text-xs text-neon-red/50">IP_TRACED:</span> {{ $session->ip_address }}
                            </div>
                        </div>
                        
<div class="text-left sm:text-right w-full sm:w-auto mt-2 sm:mt-0 bg-black/30 sm:bg-transparent p-2 sm:p-0">
                            <div class="text-[9px] text-neon-blue/50 tracking-widest uppercase mb-1">CREDENTIALS_BREACHED</div>
                            <div class="text-xs md:text-sm text-neon-alert mt-1 break-all font-mono-tech">
                                <span class="opacity-60 text-[10px]">U:</span> 
                                <span class="text-white">{{ !empty($session->username_attempt) && !in_array($session->username_attempt, ['Honeypot_Target', 'API_BOT']) ? $session->username_attempt : '[ NO_INPUT ]' }}</span>
                            </div>
                            <div class="text-xs md:text-sm text-neon-red mt-1 break-all font-mono-tech">
                                <span class="opacity-60 text-[10px]">P:</span> 
                                <span class="text-white">{{ !empty($session->password_attempt) && !in_array($session->password_attempt, ['Unknown', 'brute_force_payload']) ? $session->password_attempt : '[ NO_INPUT ]' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="text-[10px] opacity-60 flex justify-between mb-2">
                            <span>EXTRACTED_PAYLOAD_EXECUTION</span>
                            <span>[RAW_BASH]</span>
                        </div>
                        <div class="bg-void border border-neon-blue/20 p-3 h-28 overflow-y-auto text-[10px] md:text-[11px] text-neon-green/90 leading-relaxed font-mono shadow-inner whitespace-pre-wrap">
                            <div><span class="text-neon-blue/50 mr-2">root@svr:~#</span>[ACTION]: {{ $session->action_type }}</div>
                            <div><span class="text-neon-blue/50 mr-2">root@svr:~#</span>[TARGET]: /wp-admin</div>
                            <div class="text-neon-red blink mt-1">> ACCESS DENIED.</div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-neon-blue/20 flex flex-wrap justify-between items-center mt-auto gap-3">
                        <div class="flex gap-1">
                            <span class="w-1 h-3 bg-neon-blue/30 block"></span>
                            <span class="w-1 h-3 bg-neon-blue/50 block"></span>
                            <span class="w-1 h-3 bg-neon-blue block"></span>
                        </div>
                        <button onclick="analyzeHacker({{ $session->id }}, '{{ $session->ip_address }}')" class="w-full sm:w-auto bg-neon-blue/10 border border-neon-blue text-neon-blue hover:bg-neon-blue hover:text-void hover:shadow-[0_0_15px_#00f0ff] text-[9px] md:text-[10px] font-bold tracking-[0.2em] uppercase px-4 md:px-6 py-2 transition-all">
                            Execute_AI_Analysis
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-1 xl:col-span-2 cyber-border bg-surface p-8 md:p-12 text-center flex flex-col items-center justify-center gap-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 border-4 border-dashed border-neon-blue/30 rounded-full animate-spin"></div>
                    <div class="text-neon-blue text-base md:text-lg tracking-[0.3em] uppercase glitch-text" data-text="GRID_SECURE">GRID_SECURE</div>
                    <div class="text-neon-blue/50 text-[10px] md:text-xs tracking-widest uppercase text-center">No hostile entities currently isolated in containment field.</div>
                </div>
                @endforelse
            </div>
        </div>
    </main>

    <div id="aiModal" class="fixed inset-0 bg-void/95 backdrop-blur-xl hidden items-center justify-center z-50 p-2 md:p-4">
        <div class="w-full max-w-5xl cyber-border bg-surface relative overflow-hidden flex flex-col h-[90vh] md:h-[80vh]">
            <div class="bg-grid/80 border-b border-neon-blue/30 px-4 md:px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center relative z-10 gap-3">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-3 h-3 bg-neon-red animate-pulse shrink-0"></div>
                    <div>
                        <h2 class="text-[11px] md:text-sm font-bold text-white tracking-[0.1em] md:tracking-[0.3em] uppercase">SHIELD-AI // NEURAL_ANALYSIS_ENGINE</h2>
                        <div id="targetIP" class="text-[9px] md:text-[10px] text-neon-red tracking-widest mt-1">TARGET_LOCKED: NULL</div>
                    </div>
                </div>
                <button onclick="closeModal()" class="w-full sm:w-auto border border-neon-red text-neon-red hover:bg-neon-red hover:text-void px-4 py-2 sm:py-1 text-[10px] md:text-xs font-bold tracking-widest transition-colors uppercase text-center">
                    Abort_Link
                </button>
            </div>

            <div id="aiLoader" class="absolute inset-0 flex flex-col items-center justify-center z-20 bg-surface/90 hidden">
                <div class="text-4xl md:text-6xl text-neon-blue mb-4 opacity-50 font-black tracking-tighter animate-pulse">///</div>
                <div id="loaderText" class="text-neon-blue text-[10px] md:text-xs tracking-[0.2em] md:tracking-[0.3em] uppercase mb-4 text-center px-4">Establishing Neural Link...</div>
                <div class="w-48 md:w-64 h-1 border border-neon-blue/50 relative overflow-hidden">
                    <div class="absolute top-0 left-0 h-full bg-neon-blue w-1/3 animate-[scan_1s_ease-in-out_infinite_alternate]"></div>
                </div>
                <div class="mt-8 text-[8px] text-neon-blue/40 font-mono tracking-widest space-y-1 text-center" id="matrixOutput">
                    0x88FFA INITIALIZING TENSOR CORES...<br>
                    0x99BB2 DECRYPTING BEHAVIORAL PATTERNS...<br>
                    0x11AA0 BYPASSING ENCRYPTION HASH...
                </div>
            </div>

            <div class="flex-1 p-4 md:p-6 lg:p-10 overflow-y-auto relative z-10 bg-[radial-gradient(ellipse_at_center,rgba(0,240,255,0.05)_0%,rgba(0,0,0,0)_70%)]">
                <div class="absolute top-4 right-4 md:top-6 md:right-6 opacity-20 text-3xl md:text-[50px] font-black pointer-events-none tracking-tighter hidden sm:block">AI_CORE</div>
                <div id="aiContent" class="text-neon-blue/90 font-mono whitespace-pre-line leading-[1.6] md:leading-[1.8] text-xs md:text-sm hidden"></div>
            </div>
            
            <div class="bg-grid/80 border-t border-neon-blue/30 px-4 md:px-6 py-3 flex justify-between items-center z-10">
                <div class="text-[8px] md:text-[10px] text-neon-blue/50 tracking-widest uppercase">CONNECTION_ENCRYPTED // 4096-BIT RSA</div>
                <div class="flex gap-2 shrink-0">
                    <span class="w-2 h-2 bg-neon-blue block"></span><span class="w-2 h-2 bg-neon-blue block"></span><span class="w-2 h-2 bg-neon-blue/30 block"></span>
                </div>
            </div>
        </div>
    </div>

<script>
    function analyzeHacker(sessionId, ipAddress) {
        const modal = document.getElementById('aiModal'); 
        const loader = document.getElementById('aiLoader'); 
        const content = document.getElementById('aiContent'); 
        const targetIpDisplay = document.getElementById('targetIP');
        
        targetIpDisplay.innerText = "TARGET_LOCKED: " + ipAddress; 
        modal.classList.remove('hidden'); 
        modal.classList.add('flex'); 
        loader.classList.remove('hidden'); 
        content.classList.add('hidden');
        
        let phases = ["Establishing Neural Link...", "Extracting Payload Signatures...", "Querying Gemini Cyber-Model...", "Synthesizing Threat Report..."];
        let step = 0; 
        let phaseInterval = setInterval(() => { 
            step++; 
            if(step < phases.length) { 
                document.getElementById('loaderText').innerText = phases[step]; 
            } 
        }, 800);
        
        // 🛡️ FIX LỖI 404: Đã sửa lại đường dẫn fetch thành /predict/${sessionId} để khớp với Tường lửa
        fetch(`/predict/${sessionId}`)
        .then(response => {
            if (!response.ok) throw new Error("UPLINK DENIED. STATUS: " + response.status);
            return response.json();
        })
        .then(data => {
            clearInterval(phaseInterval); 
            loader.classList.add('hidden'); 
            content.classList.remove('hidden');
            
            if(data.prediction) {
                let text = data.prediction.replace(/\*\*/g, ''); 
                // Bổ sung thêm class whitespace-pre-wrap để AI xuống dòng cho đẹp
                content.innerHTML = `
                    <div class="border-l-4 border-neon-red pl-3 md:pl-4 mb-4 md:mb-6">
                        <div class="text-neon-red text-xs md:text-sm font-bold tracking-widest uppercase mb-1">=== COGNITIVE THREAT ASSESSMENT ===</div>
                        <div class="text-[9px] md:text-[10px] text-neon-blue/50 tracking-widest">TIMESTAMP: ${new Date().toISOString()}</div>
                    </div>
                    <div class="text-white/90 drop-shadow-[0_0_2px_rgba(255,255,255,0.2)] whitespace-pre-wrap leading-relaxed">${text}</div>`;
            } else if(data.error) { 
                content.innerHTML = `<div class="bg-neon-red/20 border border-neon-red text-neon-red p-4 font-bold tracking-widest uppercase">SYSTEM_FAULT: ${data.error}</div>`; 
            }
        }).catch(err => { 
            clearInterval(phaseInterval); 
            loader.classList.add('hidden'); 
            content.classList.remove('hidden'); 
            content.innerHTML = `<div class="bg-neon-red/20 border border-neon-red text-neon-red p-4 font-bold tracking-widest uppercase">UPLINK_SEVERED: ${err.message}</div>`; 
        });
    }

    function closeModal() { 
        document.getElementById('aiModal').classList.remove('flex'); 
        document.getElementById('aiModal').classList.add('hidden'); 
        document.getElementById('aiLoader').classList.add('hidden'); 
        document.getElementById('aiContent').classList.add('hidden'); 
    }

    // --- ĐOẠN RADAR ĐÃ ĐƯỢC NÂNG CẤP ---
    setInterval(() => {
        let aiModal = document.getElementById('aiModal');
        if(!aiModal) return;
        
        let isAiOpen = !aiModal.classList.contains('hidden');

        if (isAiOpen) {
            // Đang xem bảng AI -> Đóng băng Radar, gia hạn thêm 15s để không bị reload văng màn hình
            localStorage.setItem('shieldRadarTarget', Date.now() + 15000);
            return; 
        }

        let targetTime = localStorage.getItem('shieldRadarTarget');
        if (!targetTime) {
            localStorage.setItem('shieldRadarTarget', Date.now() + 15000);
        } else {
            let timeLeft = Math.ceil((targetTime - Date.now()) / 1000);
            if (timeLeft <= 0) { 
                localStorage.setItem('shieldRadarTarget', Date.now() + 15000); 
                setTimeout(() => { window.location.reload(); }, 500); 
            }
        }
    }, 1000);
</script>
</body>
</html>