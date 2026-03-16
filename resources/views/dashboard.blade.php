<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Master Command Center</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/three"></script>
    <script src="https://unpkg.com/globe.gl"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cyber: { base: '#030712', panel: '#0f172a', border: '#1e293b', blue: '#3b82f6', blueGlow: '#60a5fa', red: '#ef4444', green: '#10b981', text: '#e2e8f0', muted: '#64748b' },
                        neon: { blue: '#00f0ff', red: '#ff003c', green: '#00ff41', alert: '#ffb000' }
                    },
                    backgroundImage: {
                        'cyber-grid': "linear-gradient(to right, #1e293b 1px, transparent 1px), linear-gradient(to bottom, #1e293b 1px, transparent 1px)"
                    }
                }
            }
        }
    </script>
    
    <style>
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #030712; border-left: 1px solid #1e293b; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; }
        
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Inter:wght@400;600;800&display=swap');
        .font-mono-tech { font-family: 'Share Tech Mono', monospace; }
        .font-sans-ui { font-family: 'Inter', sans-serif; }

        .scanline {
            width: 100%; height: 100px;
            background: linear-gradient(0deg, rgba(59, 130, 246, 0) 0%, rgba(59, 130, 246, 0.1) 50%, rgba(59, 130, 246, 0) 100%);
            opacity: 0.1; position: absolute; bottom: 100%;
            animation: scanline 8s linear infinite; pointer-events: none; z-index: 50;
        }
        @keyframes scanline { 0% { bottom: 100%; } 100% { bottom: -100px; } }

        .hud-panel { position: relative; }
        .hud-panel::before, .hud-panel::after { content: ''; position: absolute; width: 10px; height: 10px; border: 2px solid transparent; pointer-events: none; }
        .hud-panel::before { top: -1px; left: -1px; border-top-color: #3b82f6; border-left-color: #3b82f6; }
        .hud-panel::after { bottom: -1px; right: -1px; border-bottom-color: #3b82f6; border-right-color: #3b82f6; }
        
        .hud-panel-danger::before { border-top-color: #ef4444; border-left-color: #ef4444; }
        .hud-panel-danger::after { border-bottom-color: #ef4444; border-right-color: #ef4444; }

        .pulse-text { animation: blink 2s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        
        .crt::before { content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03)); z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none; opacity: 0.2; }
    </style>
</head>
<body class="bg-cyber-base text-cyber-text font-sans-ui h-screen flex flex-col lg:flex-row overflow-hidden relative crt">

    <div class="absolute inset-0 bg-cyber-grid bg-[size:30px_30px] opacity-20 pointer-events-none"></div>
    <div class="scanline"></div>

    <div class="lg:hidden flex justify-between items-center px-6 h-16 bg-cyber-base border-b border-cyber-border z-50 flex-shrink-0 relative">
        <h1 class="text-xl font-black text-white tracking-widest drop-shadow-[0_0_8px_rgba(59,130,246,0.8)]">Q3T<span class="text-cyber-blue">-MLSFS</span></h1>
        <button onclick="document.getElementById('sidebar').classList.toggle('hidden')" class="border border-cyber-blue text-cyber-blue hover:bg-cyber-blue hover:text-white px-3 py-1 text-[10px] font-mono-tech tracking-widest uppercase transition-colors">
            [ MENU ]
        </button>
    </div>

    <aside id="sidebar" class="hidden lg:flex flex-col w-full lg:w-72 bg-cyber-base/95 lg:bg-cyber-base/80 backdrop-blur-md border-r border-cyber-border flex-shrink-0 z-40 absolute lg:relative h-[calc(100vh-4rem)] lg:h-screen top-16 lg:top-0 left-0 overflow-y-auto lg:overflow-visible">
        <div class="absolute right-0 top-0 bottom-0 w-[1px] bg-gradient-to-b from-transparent via-cyber-blue to-transparent opacity-50 hidden lg:block"></div>
        
        <div>
            <div class="h-24 hidden lg:flex flex-col justify-center px-6 border-b border-cyber-border relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyber-blue to-transparent"></div>
                <h1 class="text-3xl font-black text-white tracking-widest drop-shadow-[0_0_8px_rgba(59,130,246,0.8)]">Q3T<span class="text-cyber-blue">-MLSFS</span></h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[10px] text-cyber-blue font-mono-tech tracking-[0.2em] uppercase">SEC.CORE // V1.0.9</span>
                    <span class="h-1 w-1 bg-cyber-blue rounded-full pulse-text"></span>
                </div>
            </div>

            <nav class="mt-8 flex flex-col gap-2 px-4">
                <a href="/dashboard" class="group relative px-4 py-3 bg-cyber-blue/10 border border-cyber-blue/30 text-white font-bold transition-all flex items-center justify-between">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyber-blue"></div>
                    <span class="uppercase tracking-wider text-sm">Command Center</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">[ ACTV ]</span>
                </a>
                
                <a href="{{ route('honeypot') }}" class="px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-medium transition-all flex justify-between items-center">
                    <span class="uppercase tracking-wider text-sm">Honeypot Matrix</span>
                    <span class="text-[10px] font-mono-tech">L_01</span>
                </a>
                
                <a href="{{ route('ai_analysis') }}" class="px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-medium transition-all flex justify-between items-center">
                    <span class="uppercase tracking-wider text-sm">AI Threat Intel</span>
                    <span class="text-[10px] font-mono-tech">L_02</span>
                </a>
                
                <a href="{{ route('webshell') }}" class="px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-medium transition-all flex justify-between items-center">
                    <span class="uppercase tracking-wider text-sm">Infra Matrix</span>
                    <span class="text-[10px] font-mono-tech">L_03</span>
                </a>
                
                <a href="{{ route('system_logs') }}" class="px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-medium transition-all flex justify-between items-center">
                    <span class="uppercase tracking-wider text-sm">Audit Logs</span>
                    <span class="text-[10px] font-mono-tech">L_04</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-cyber-border bg-cyber-panel/50 relative flex flex-col gap-3 mt-auto">
            <div class="absolute top-0 right-0 p-2 text-[8px] text-cyber-muted font-mono-tech">ID: ADM-001</div>
            <div class="flex items-center gap-3 px-2">
                <div class="h-10 w-10 rounded-sm bg-cyber-base border border-cyber-blue/50 flex items-center justify-center text-cyber-blue font-mono-tech text-lg shadow-[0_0_10px_rgba(59,130,246,0.3)]">A</div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Administrator</span>
                    <span class="text-[10px] text-cyber-green font-mono-tech pulse-text">AUTH_VERIFIED [OK]</span>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="m-0 px-2 w-full">
                @csrf
                <button type="submit" class="w-full bg-cyber-red/10 border border-cyber-red/40 text-cyber-red hover:bg-cyber-red hover:text-white hover:shadow-[0_0_15px_rgba(239,68,68,0.6)] py-2 text-[10px] font-bold tracking-[0.2em] uppercase transition-all duration-300 flex items-center justify-center gap-2">
                    <span class="w-1.5 h-1.5 bg-cyber-red rounded-full animate-pulse"></span>
                    LOGOUT_SYSTEM
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative z-10 overflow-hidden">
        
        <header class="py-4 lg:h-20 bg-cyber-base/80 backdrop-blur-lg border-b border-cyber-border flex flex-col lg:flex-row items-start lg:items-center justify-between px-4 lg:px-8 z-20 gap-4">
            <div class="flex flex-col">
                <h2 class="text-lg font-bold text-white tracking-widest uppercase">Global Threat Matrix</h2>
                <div class="flex items-center gap-2 mt-1 flex-wrap">
                    <span class="h-1.5 w-1.5 bg-cyber-green rounded-full pulse-text shadow-[0_0_5px_#10b981]"></span>
                    <span class="text-[10px] md:text-xs font-mono-tech text-cyber-green tracking-widest uppercase">Network Encrypted // Secured</span>
                    <span class="text-cyber-muted text-xs hidden md:inline">|</span>
                    <span class="text-[10px] md:text-xs font-mono-tech text-cyber-blue">UPLINK_NODE: 103.27.61.76</span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] text-cyber-muted font-mono-tech tracking-widest uppercase">Defense_Protocol:</span>
                    <form action="{{ url('/toggle-auto') }}" method="POST" class="m-0">
                        @csrf
                        @php $isAuto = \Illuminate\Support\Facades\Cache::get('auto_block_enabled', false); @endphp
                        <button type="submit" class="border {{ $isAuto ? 'border-cyber-green text-cyber-green bg-cyber-green/10' : 'border-cyber-red text-cyber-red bg-cyber-red/10' }} px-4 py-2 text-[10px] font-bold tracking-widest uppercase transition-all shadow-[0_0_10px_rgba(0,0,0,0.5)]">
                            [ {{ $isAuto ? 'AUTO_ON' : 'MANUAL' }} ]
                        </button>
                    </form>
                </div>

                <form action="{{ url('/clear-logs') }}" method="POST" class="m-0" onsubmit="return confirm('PURGE ALL DATA?');">
                    @csrf
                    <button type="submit" class="bg-cyber-red/90 hover:bg-cyber-red text-white font-mono-tech px-6 py-2 text-[10px] font-bold tracking-[0.2em] uppercase transition-all shadow-[0_0_15px_rgba(239,68,68,0.4)] border border-cyber-red">
                        PURGE_DATABANKS
                    </button>
                </form>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8 relative">
            
            @if(session('alert'))
                <div class="mb-6 border border-cyber-blue bg-cyber-blue/20 p-4 flex justify-between items-center shadow-[0_0_15px_rgba(59,130,246,0.4)]">
                    <span class="font-mono-tech text-white font-bold tracking-widest uppercase">[ SYSTEM_NOTICE ] {{ session('alert') }}</span>
                    <button onclick="this.parentElement.style.display='none'" class="text-cyber-muted hover:text-white font-mono-tech text-xs border border-cyber-muted px-2 py-1">[DISMISS]</button>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-cyber-panel/60 border border-cyber-red/40 p-5 hud-panel hud-panel-danger backdrop-blur-sm relative overflow-hidden group">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-cyber-red text-xs font-mono-tech font-bold uppercase tracking-widest">High_Risk_Anomalies</p>
                        <span class="text-[9px] text-cyber-red/50 font-mono-tech border border-cyber-red/30 px-1">LVL: CRITICAL</span>
                    </div>
                    <div class="flex items-end gap-3">
                       <span id="high-risk-count" class="text-5xl font-mono-tech font-black text-white drop-shadow-[0_0_10px_rgba(239,68,68,0.8)]">{{ $highRiskCount }}</span>
                        <span class="text-cyber-muted font-mono-tech text-xs mb-1 uppercase">DETECTED</span>
                    </div>
                    <div class="mt-4 w-full h-[2px] bg-cyber-red/20"><div class="h-full bg-cyber-red w-[85%] animate-pulse"></div></div>
                </div>

                <div class="bg-cyber-panel/60 border border-cyber-border p-5 hud-panel backdrop-blur-sm relative">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-cyber-blue text-xs font-mono-tech font-bold uppercase tracking-widest">Payloads_Intercepted</p>
                        <span class="text-[9px] text-cyber-blue/50 font-mono-tech border border-cyber-blue/30 px-1">SRC: SHIELD_CORE</span>
                    </div>
                    <div class="flex items-end gap-3">
                        <span class="text-5xl font-mono-tech font-black text-cyber-text">{{ $webShellBlocked }}</span>
                        <span class="text-cyber-muted font-mono-tech text-xs mb-1 uppercase">FILES NEUTRALIZED</span>
                    </div>
                    <div class="mt-4 flex gap-1"><div class="h-[2px] w-full bg-cyber-blue"></div></div>
                </div>

                <div class="bg-cyber-panel/60 border border-cyber-border p-5 hud-panel backdrop-blur-sm relative">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-cyber-text text-xs font-mono-tech font-bold uppercase tracking-widest">Global_Risk_Factor</p>
                        <span class="text-[9px] text-cyber-muted font-mono-tech border border-cyber-border px-1">AVG_24H</span>
                    </div>
                    <div class="flex items-end gap-1">
                        <span class="text-5xl font-mono-tech font-black text-cyber-text">{{ round($avgRisk, 1) }}</span>
                        <span class="text-2xl font-mono-tech text-cyber-muted">%</span>
                    </div>
                    <div class="mt-4 flex items-end gap-[2px] h-[10px] opacity-40"><div class="w-full bg-cyber-muted h-[40%]"></div><div class="w-full bg-cyber-muted h-[100%]"></div><div class="w-full bg-cyber-muted h-[60%]"></div></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
                <div class="bg-cyber-base border border-cyber-border hud-panel flex flex-col p-1 relative shadow-2xl">
                    <div class="absolute top-0 right-4 px-2 py-1 bg-cyber-border text-[8px] font-mono-tech text-cyber-text z-10 tracking-widest">3D_SPATIAL_TRACKING</div>
                    
                    <div class="px-4 py-3 border-b border-cyber-border bg-cyber-panel flex justify-between items-center">
                        <span class="text-cyber-blue font-mono-tech text-sm font-bold tracking-widest uppercase">/// Global_Threat_Matrix</span>
                        <span class="text-[9px] text-neon-green animate-pulse">[ UPLINK_SECURED ]</span>
                    </div>
                    
                    <div class="p-1 flex-1 relative bg-[#010308]">
                        <div id="globeViz" class="w-full h-[400px] lg:h-[450px] cursor-move"></div>
                        
                        <div class="absolute top-3 left-3 z-10 text-[9px] text-neon-blue font-mono-tech tracking-widest bg-black/60 p-2 border border-neon-blue/30 backdrop-blur-sm pointer-events-none">
                            <span class="text-neon-red animate-pulse">●</span> LIVE_UPLINK // VISUALIZATION
                        </div>
                    </div>
                </div>

                <div class="bg-cyber-base border border-cyber-border hud-panel flex flex-col p-1 relative shadow-2xl">
                    <div class="absolute top-0 right-4 px-2 py-1 bg-cyber-border text-[8px] font-mono-tech text-cyber-text z-10 tracking-widest">DATA_CLASSIFICATION</div>
                    <div class="px-4 py-3 border-b border-cyber-border bg-cyber-panel">
                        <span class="text-cyber-text font-mono-tech text-sm font-bold tracking-widest uppercase">/// Vector_Analysis</span>
                    </div>
                    <div class="p-6 flex-1 bg-cyber-base relative min-h-[300px]">
                        <canvas id="threatChart" class="w-full h-full relative z-10"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-cyber-base border border-cyber-border hud-panel flex flex-col p-1 shadow-2xl">
                <div class="px-4 py-3 border-b border-cyber-border bg-cyber-panel flex justify-between items-center">
                    <span class="text-cyber-text font-mono-tech text-sm font-bold tracking-widest uppercase">/// Live_Audit_Stream</span>
                    <span class="text-[10px] text-cyber-muted font-mono-tech pulse-text uppercase">Receiving Telemetry...</span>
                </div>
                
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse font-mono-tech whitespace-nowrap">
                        <thead>
                            <tr class="bg-cyber-panel/50 border-b border-cyber-border">
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em]">Source_IP</th>
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em]">Signature_Type</th>
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em]">Risk_Score</th>
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em]">Protocol_Action</th>
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em] text-right">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody id="live-traffic-body" class="divide-y divide-cyber-border/40 text-sm">
                            @forelse($logs as $log)
                            <tr class="hover:bg-cyber-blue/5 transition-colors group">
                                <td class="py-3 px-6 text-white font-bold tracking-wider">
                                    <span class="text-cyber-muted opacity-0 group-hover:opacity-100 mr-2">></span>{{ $log->ip_address }}
                                </td>
                                <td class="py-3 px-6 text-cyber-muted">{{ $log->attack_type }}</td>
                                <td class="py-3 px-6">
                                    <span class="{{ $log->risk_score >= 90 ? 'text-cyber-red' : ($log->risk_score >= 50 ? 'text-orange-400' : 'text-cyber-green') }} font-bold">
                                        [{{ $log->risk_score }}%]
                                    </span>
                                </td>
                                <td class="py-3 px-6">
                                    @php $isBlocked = in_array($log->status, ['Auto-Blocked', 'Manual-Blocked', 'sys_block']); @endphp
                                    @if($isBlocked)
                                        <a href="{{ url('/unblock-ip/' . $log->id) }}" class="text-[10px] text-cyber-green border border-cyber-green hover:bg-cyber-green hover:text-black px-3 py-1 uppercase font-bold tracking-tighter">RESTORE_ACCESS</a>
                                    @else
                                        <a href="{{ url('/block-ip/' . $log->id) }}" class="text-[10px] text-cyber-red border border-cyber-red hover:bg-cyber-red hover:text-white px-3 py-1 uppercase font-bold tracking-tighter">TERMINATE_IP</a>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-right text-xs text-cyber-muted">{{ $log->created_at->format('H:i:s d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-12 text-center text-cyber-muted uppercase tracking-widest text-xs">No hostile signatures detected in current stream.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="h-10"></div>
        </div>
    </main>

    <div style="position: fixed; bottom: 20px; right: 20px; background: rgba(0,0,0,0.9); color: #00ff00; padding: 10px 20px; border: 1px solid #3b82f6; font-family: monospace; z-index: 9999; font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;">
        <span id="radar-dot" class="text-cyber-red font-black pulse-text mr-2">[!]</span> 
        SHIELD-AI RADAR SWEEP: <span id="countdown">5</span>s
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        /* =========================================================
           1. 3D GLOBE INITIALIZATION
           ========================================================= */
        const globeContainer = document.getElementById('globeViz');
        if (globeContainer) {
            const honeypotLat = 21.0285; 
            const honeypotLng = 105.8542;

            const dbData = @json($mapData ?? []);
            let arcsData = [];
            let ringsData = [{ lat: honeypotLat, lng: honeypotLng, color: '#00ff41', isHoneypot: true }];

            if (dbData.length > 0) {
                dbData.forEach(log => {
                    if(log.latitude && log.longitude) {
                        const isHighRisk = log.risk_score >= 90;
                        const arcColor = isHighRisk ? '#ff003c' : '#ffb000';
                        
                        arcsData.push({
                            startLat: parseFloat(log.latitude),
                            startLng: parseFloat(log.longitude),
                            endLat: honeypotLat,
                            endLng: honeypotLng,
                            color: [arcColor, '#00f0ff']
                        });

                        ringsData.push({
                            lat: parseFloat(log.latitude),
                            lng: parseFloat(log.longitude),
                            color: arcColor,
                            isHoneypot: false
                        });
                    }
                });
            }

            // ĐÃ THÊM KHÓA KÍCH THƯỚC NGAY TẠI ĐÂY LÚC KHỞI TẠO
            const world = Globe()(globeContainer)
                .width(globeContainer.clientWidth)   // <--- Ép chiều rộng
                .height(globeContainer.clientHeight) // <--- Ép chiều cao
                .globeImageUrl('//unpkg.com/three-globe/example/img/earth-dark.jpg')
                .bumpImageUrl('//unpkg.com/three-globe/example/img/earth-topology.png')
                .backgroundColor('#010308')
                .arcsData(arcsData)
                .arcColor('color')
                .arcDashLength(0.4) 
                .arcDashGap(4)      
                .arcDashInitialGap(() => Math.random() * 5)
                .arcDashAnimateTime(2000)
                .ringsData(ringsData)
                .ringColor('color')
                .ringMaxRadius(d => d.isHoneypot ? 8 : 3)
                .ringPropagationSpeed(d => d.isHoneypot ? 2 : 1)
                .ringRepeatPeriod(1000);

            world.controls().autoRotate = true;
            world.controls().autoRotateSpeed = 1.0; 
            world.controls().enableZoom = false; 
            world.pointOfView({ lat: 15, lng: 105, altitude: 2.2 }, 2000);
            
            window.addEventListener('resize', () => {
                world.width(globeContainer.clientWidth);
                world.height(globeContainer.clientHeight);
            });
        }

        /* =========================================================
           2. CHART INITIALIZATION
           ========================================================= */
        const ctx = document.getElementById('threatChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['SCAN', 'BRUTE_FORCE', 'EXPLOIT', 'MALWARE'],
                datasets: [{
                    data: [{{ $scanCount ?? 0 }}, {{ $bruteForceCount ?? 0 }}, {{ $exploitCount ?? 0 }}, {{ $malwareCount ?? 0 }}],
                    backgroundColor: ['#3b82f6', '#ef4444', '#f97316', '#10b981'],
                    borderWidth: 0, barPercentage: 0.5
                }]
            },
            options: { 
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: '#1e293b' } }, x: { grid: { display: false } } }
            }
        });

        /* =========================================================
           3. RADAR SYNC SYSTEM (5s)
           ========================================================= */
        function startGlobalRadar() {
            setInterval(() => {
                let targetTime = parseInt(localStorage.getItem('shieldRadarTarget')) || (Date.now() + 5000);
                let timeLeft = Math.ceil((targetTime - Date.now()) / 1000);
                
                if (timeLeft <= 0) {
                    targetTime = Date.now() + 5000;
                    localStorage.setItem('shieldRadarTarget', targetTime);
                    document.getElementById('countdown').innerText = "SCAN";
                    
                    fetch("{{ url('/live-radar') }}").then(r => r.json()).then(data => {
                        if(data.status === 'success') {
                            document.getElementById('high-risk-count').innerText = data.highRiskCount;
                            const tbody = document.getElementById('live-traffic-body');
                            let html = '';
                            data.logs.forEach(log => {
                                let isBlocked = ['Auto-Blocked', 'Manual-Blocked', 'sys_block'].includes(log.status);
                                let riskColor = log.risk_score >= 90 ? 'text-cyber-red' : (log.risk_score >= 50 ? 'text-orange-400' : 'text-cyber-green');
                                html += `
                                    <tr class="border-b border-cyber-border/40 hover:bg-cyber-blue/5 group transition-colors">
                                        <td class="py-3 px-6 text-white font-bold"><span class="text-cyber-muted opacity-0 group-hover:opacity-100 mr-2">></span>${log.ip_address}</td>
                                        <td class="py-3 px-6 text-cyber-muted">${log.attack_type}</td>
                                        <td class="py-3 px-6"><span class="${riskColor} font-bold">[${log.risk_score}%]</span></td>
                                        <td class="py-3 px-6">
                                            <a href="${isBlocked ? '/unblock-ip/' : '/block-ip/'}${log.id}" class="text-[10px] border ${isBlocked ? 'border-cyber-green text-cyber-green' : 'border-cyber-red text-cyber-red'} px-3 py-1 uppercase font-bold tracking-tighter">
                                                ${isBlocked ? 'RESTORE_ACCESS' : 'TERMINATE_IP'}
                                            </a>
                                        </td>
                                        <td class="py-3 px-6 text-right text-xs text-cyber-muted">${new Date(log.created_at).toLocaleTimeString()}</td>
                                    </tr>`;
                            });
                            tbody.innerHTML = html;
                        }
                    });
                } else {
                    document.getElementById('countdown').innerText = timeLeft;
                }
            }, 1000);
        }
        startGlobalRadar();
    });
</script>
</body>
</html>