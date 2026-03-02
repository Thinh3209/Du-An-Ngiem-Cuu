<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Threat Containment Matrix (L1)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        void: '#010308',
                        surface: '#050a14',
                        grid: '#0a192f',
                        neon: { blue: '#00f0ff', red: '#ff003c', green: '#00ff41', alert: '#ffb000' }
                    },
                    fontFamily: {
                        mono: ['"Share Tech Mono"', '"Courier New"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <style>
        /* CRT Screen Effects */
        body { margin: 0; overflow-x: hidden; background-color: #010308; }
        .crt::before {
            content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
            z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none;
        }
        .scanline {
            width: 100%; height: 10px; position: fixed; z-index: 9999;
            background: linear-gradient(to bottom, rgba(0,240,255,0), rgba(0,240,255,0.1) 50%, rgba(0,240,255,0));
            opacity: 0.1; animation: scan 6s linear infinite; pointer-events: none;
        }
        @keyframes scan { 0% { top: -10%; } 100% { top: 110%; } }

        .cyber-border {
            position: relative; border: 1px solid #00f0ff;
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.1), inset 0 0 20px rgba(0, 240, 255, 0.05);
        }
        .cyber-border::before, .cyber-border::after {
            content: ''; position: absolute; width: 15px; height: 15px; border: 2px solid #00f0ff; pointer-events: none;
        }
        .cyber-border::before { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .cyber-border::after { bottom: -2px; right: -2px; border-left: none; border-top: none; }

        .glitch-text { position: relative; display: inline-block; }
        .glitch-text::before, .glitch-text::after {
            content: attr(data-text); position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.8;
        }
        .glitch-text::before { left: 2px; text-shadow: -1px 0 red; animation: glitch-anim-1 2s infinite linear alternate-reverse; }
        .glitch-text::after { left: -2px; text-shadow: -1px 0 blue; animation: glitch-anim-2 3s infinite linear alternate-reverse; }
        @keyframes glitch-anim-1 { 0% { clip-path: inset(20% 0 80% 0); } 20% { clip-path: inset(60% 0 10% 0); } 40% { clip-path: inset(40% 0 50% 0); } 60% { clip-path: inset(80% 0 5% 0); } 80% { clip-path: inset(10% 0 70% 0); } 100% { clip-path: inset(30% 0 20% 0); } }
        @keyframes glitch-anim-2 { 0% { clip-path: inset(10% 0 60% 0); } 20% { clip-path: inset(30% 0 20% 0); } 40% { clip-path: inset(70% 0 10% 0); } 60% { clip-path: inset(20% 0 50% 0); } 80% { clip-path: inset(50% 0 30% 0); } 100% { clip-path: inset(5% 0 80% 0); } }

        .hex-stream {
            writing-mode: vertical-rl; text-orientation: mixed; white-space: nowrap; overflow: hidden;
            background: -webkit-linear-gradient(top, rgba(0,240,255,0), rgba(0,240,255,0.8), rgba(0,240,255,0));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; animation: flow 10s linear infinite;
        }
        @keyframes flow { 0% { transform: translateY(-100%); } 100% { transform: translateY(100%); } }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #010308; }
        ::-webkit-scrollbar-thumb { background: #00f0ff; }
    </style>
</head>
<body class="text-neon-blue font-mono crt">
    <div class="scanline"></div>

    <div class="fixed inset-0 bg-[linear-gradient(to_right,#0a192f_1px,transparent_1px),linear-gradient(to_bottom,#0a192f_1px,transparent_1px)] bg-[size:40px_40px] opacity-20 z-[-1]"></div>
    <div class="fixed left-4 top-0 bottom-0 w-4 flex flex-col justify-between z-[-1] opacity-30 text-[8px] tracking-widest pointer-events-none">
        <div class="hex-stream">0xFA 0x11 0x4C 0x89 0x2B 0xAA 0xFF 0x01 0x9C</div>
        <div class="hex-stream" style="animation-delay: -5s; color: #ff003c;">0xDE 0xAD 0xBE 0xEF 0x40 0x40 0x00</div>
    </div>

    <div class="max-w-[1400px] mx-auto p-6 md:p-10 relative z-10">
        
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end border-b border-neon-blue/30 pb-6 mb-8 relative">
            <div class="absolute -bottom-[1px] left-0 w-1/3 h-[2px] bg-neon-blue shadow-[0_0_10px_#00f0ff]"></div>
            
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-4 text-xs tracking-[0.3em] opacity-70">
                    <span>SYS.OP: NORMAL</span>
                    <span class="text-neon-red animate-pulse">■ REC</span>
                    <span>NET_SYNC: 99.9%</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-widest text-white drop-shadow-[0_0_15px_rgba(0,240,255,0.6)] glitch-text" data-text="ISOLATION_MATRIX">
                    ISOLATION_MATRIX
                </h1>
                <p class="text-xs text-neon-blue/70 tracking-[0.2em]">L1_HONEYPOT_INFRASTRUCTURE // COWRIE_ENGINE_ACTIVE</p>
            </div>

            <div class="mt-6 lg:mt-0 flex flex-col items-end gap-3">
                <div class="border border-neon-blue/40 px-3 py-1 bg-neon-blue/5 flex gap-4 text-[10px] tracking-widest">
                    <span>PORT: 2222</span>
                    <span class="text-neon-green">STATUS: LISTENING</span>
                </div>
                <a href="/dashboard" class="group border border-neon-blue px-6 py-2 hover:bg-neon-blue hover:text-void transition-all duration-300 font-bold tracking-[0.2em] text-xs relative overflow-hidden flex items-center gap-2">
                    <span class="w-2 h-2 bg-neon-red group-hover:bg-void"></span>
                    RETURN_TO_COMMAND
                </a>
            </div>
        </header>

        <div class="mb-4 text-xs tracking-widest uppercase opacity-60 flex justify-between">
            <span>/// Captured_Adversary_Nodes</span>
            <span>Total: {{ count($sessions) }} Entities</span>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            @forelse($sessions as $session)
            <div class="cyber-border bg-surface/80 p-5 flex flex-col gap-4 relative group hover:bg-grid/40 transition-colors backdrop-blur-sm">
                <div class="flex justify-between items-start border-b border-neon-blue/20 pb-3">
                    <div>
                        <div class="text-[9px] text-neon-blue/50 tracking-widest">ENTITY_ID: {{ $session->id }}</div>
                        <div class="text-xl font-bold text-neon-red drop-shadow-[0_0_8px_rgba(255,0,60,0.4)] flex items-center gap-2 mt-1">
                            <span class="text-xs text-neon-red/50">IP_TRACED:</span> {{ $session->ip_address }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-[9px] text-neon-blue/50 tracking-widest">CREDENTIALS_BREACHED</div>
                        <div class="text-sm text-white mt-1">
                            <span class="opacity-40 text-xs">U:</span>{{ $session->username_attempt }} <span class="opacity-40 text-xs ml-2">P:</span><span class="text-neon-alert">{{ $session->password_attempt }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex-1">
<div class="text-[9px] text-neon-blue/50 tracking-widest">ENTITY_ID: {{ $session->id }}</div>
                        <span>EXTRACTED_PAYLOAD_EXECUTION</span>
                        <span>[RAW_BASH]</span>
                    </div>
                    <div class="bg-void border border-neon-blue/20 p-3 h-28 overflow-y-auto text-[11px] text-neon-green/90 leading-relaxed font-mono shadow-inner">
<div><span class="text-neon-blue/50 mr-2">root@svr:~#</span>[ACTION]: {{ $session->action_type }}</div>
    <div><span class="text-neon-blue/50 mr-2">root@svr:~#</span>[TARGET]: /wp-admin</div>
    <div class="text-neon-red blink mt-1">> ACCESS DENIED.</div>
                    </div>
                </div>

                <div class="pt-3 border-t border-neon-blue/20 flex justify-between items-center mt-auto">
                    <div class="flex gap-1">
                        <span class="w-1 h-3 bg-neon-blue/30 block"></span>
                        <span class="w-1 h-3 bg-neon-blue/50 block"></span>
                        <span class="w-1 h-3 bg-neon-blue block"></span>
                    </div>
                    <button onclick="analyzeHacker({{ $session->id }}, '{{ $session->ip_address }}')" class="bg-neon-blue/10 border border-neon-blue text-neon-blue hover:bg-neon-blue hover:text-void hover:shadow-[0_0_15px_#00f0ff] text-[10px] font-bold tracking-[0.2em] uppercase px-6 py-2 transition-all">
                        Execute_AI_Analysis
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-1 xl:col-span-2 cyber-border bg-surface p-12 text-center flex flex-col items-center justify-center gap-4">
                <div class="w-16 h-16 border-4 border-dashed border-neon-blue/30 rounded-full animate-spin"></div>
                <div class="text-neon-blue text-lg tracking-[0.3em] uppercase glitch-text" data-text="GRID_SECURE">GRID_SECURE</div>
                <div class="text-neon-blue/50 text-xs tracking-widest uppercase">No hostile entities currently isolated in containment field.</div>
            </div>
            @endforelse
        </div>
    </div>

    <div id="aiModal" class="fixed inset-0 bg-void/95 backdrop-blur-xl hidden items-center justify-center z-50 p-4">
        <div class="w-full max-w-5xl cyber-border bg-surface relative overflow-hidden flex flex-col h-[80vh]">
            
            <div class="bg-grid/80 border-b border-neon-blue/30 px-6 py-4 flex justify-between items-center relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-3 h-3 bg-neon-red animate-pulse"></div>
                    <div>
                        <h2 class="text-sm font-bold text-white tracking-[0.3em] uppercase">SHIELD-AI // NEURAL_ANALYSIS_ENGINE</h2>
                        <div id="targetIP" class="text-[10px] text-neon-red tracking-widest mt-1">TARGET_LOCKED: NULL</div>
                    </div>
                </div>
                <button onclick="closeModal()" class="border border-neon-red text-neon-red hover:bg-neon-red hover:text-void px-4 py-1 text-xs font-bold tracking-widest transition-colors uppercase">
                    Abort_Link
                </button>
            </div>

            <div id="aiLoader" class="absolute inset-0 flex flex-col items-center justify-center z-20 bg-surface/90 hidden">
                <div class="text-6xl text-neon-blue mb-4 opacity-50 font-black tracking-tighter animate-pulse">///</div>
                <div id="loaderText" class="text-neon-blue text-xs tracking-[0.3em] uppercase mb-4">Establishing Neural Link...</div>
                <div class="w-64 h-1 border border-neon-blue/50 relative overflow-hidden">
                    <div class="absolute top-0 left-0 h-full bg-neon-blue w-1/3 animate-[scan_1s_ease-in-out_infinite_alternate]"></div>
                </div>
                <div class="mt-8 text-[8px] text-neon-blue/40 font-mono tracking-widest space-y-1 text-center" id="matrixOutput">
                    0x88FFA INITIALIZING TENSOR CORES...<br>
                    0x99BB2 DECRYPTING BEHAVIORAL PATTERNS...<br>
                    0x11AA0 BYPASSING ENCRYPTION HASH...
                </div>
            </div>

            <div class="flex-1 p-6 lg:p-10 overflow-y-auto relative z-10 bg-[radial-gradient(ellipse_at_center,rgba(0,240,255,0.05)_0%,rgba(0,0,0,0)_70%)]">
                <div class="absolute top-6 right-6 opacity-20 text-[50px] font-black pointer-events-none tracking-tighter">AI_CORE</div>
                
                <div id="aiContent" class="text-neon-blue/90 font-mono whitespace-pre-line leading-[1.8] text-sm hidden">
                    </div>
            </div>
            
            <div class="bg-grid/80 border-t border-neon-blue/30 px-6 py-3 flex justify-between items-center z-10">
                <div class="text-[10px] text-neon-blue/50 tracking-widest uppercase">CONNECTION_ENCRYPTED // 4096-BIT RSA</div>
                <div class="flex gap-2">
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
            
            // Setup & Show Modal
            targetIpDisplay.innerText = "TARGET_LOCKED: " + ipAddress;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Show Loader, Hide Content
            loader.classList.remove('hidden');
            content.classList.add('hidden');
            
            // Loader text animation simulation
            let phases = ["Establishing Neural Link...", "Extracting Payload Signatures...", "Querying Gemini Cyber-Model...", "Synthesizing Threat Report..."];
            let step = 0;
            let phaseInterval = setInterval(() => {
                step++;
                if(step < phases.length) {
                    document.getElementById('loaderText').innerText = phases[step];
                }
            }, 800);

            // Fetch Data
            fetch(`/hacker-session/${sessionId}/predict`)
                .then(response => response.json())
                .then(data => {
                    clearInterval(phaseInterval);
                    loader.classList.add('hidden');
                    content.classList.remove('hidden');

                    if(data.prediction) {
                        let text = data.prediction.replace(/\*\*/g, ''); 
                        content.innerHTML = `
                            <div class="border-l-4 border-neon-red pl-4 mb-6">
                                <div class="text-neon-red font-bold tracking-widest uppercase mb-1">=== COGNITIVE THREAT ASSESSMENT ===</div>
                                <div class="text-[10px] text-neon-blue/50 tracking-widest">TIMESTAMP: ${new Date().toISOString()}</div>
                            </div>
                            <div class="text-white/90 drop-shadow-[0_0_2px_rgba(255,255,255,0.2)]">${text}</div>
                        `;
                    } else if(data.error) {
                        content.innerHTML = `<div class="bg-neon-red/20 border border-neon-red text-neon-red p-4 font-bold tracking-widest uppercase">SYSTEM_FAULT: ${data.error}</div>`;
                    }
                })
                .catch(err => {
                    clearInterval(phaseInterval);
                    loader.classList.add('hidden');
                    content.classList.remove('hidden');
                    content.innerHTML = `<div class="bg-neon-red/20 border border-neon-red text-neon-red p-4 font-bold tracking-widest uppercase">UPLINK_SEVERED: ${err}</div>`;
                });
        }

        function closeModal() {
            document.getElementById('aiModal').classList.remove('flex');
            document.getElementById('aiModal').classList.add('hidden');
            // Reset state
            document.getElementById('aiLoader').classList.add('hidden');
            document.getElementById('aiContent').classList.add('hidden');
        }
    </script>
    <script>
    setInterval(() => {
        let targetTime = localStorage.getItem('shieldRadarTarget');
        if (targetTime) {
            let timeLeft = Math.ceil((targetTime - Date.now()) / 1000);
            
            // Khi đồng hồ chung về 0, đợi nửa giây cho Server xử lý xong rồi tự F5
            if (timeLeft <= 0) {
                // Đẩy mốc thời gian ra xa tạm để tránh việc F5 lặp vô tận
                localStorage.setItem('shieldRadarTarget', Date.now() + 15000); 
                
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        }
    }, 1000);
</script>
</body>
</html>
