<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Tactical Command Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cyber: {
                            base: '#030712',      /* Đen sâu */
                            panel: '#0f172a',     /* Xanh đen nhạt */
                            border: '#1e293b',    /* Viền xám */
                            blue: '#3b82f6',      /* Xanh dương HUD */
                            blueGlow: '#60a5fa',
                            red: '#ef4444',       /* Đỏ cảnh báo */
                            green: '#10b981',     /* Xanh an toàn */
                            text: '#e2e8f0',
                            muted: '#64748b'
                        }
                    },
                    backgroundImage: {
                        'cyber-grid': "linear-gradient(to right, #1e293b 1px, transparent 1px), linear-gradient(to bottom, #1e293b 1px, transparent 1px)"
                    }
                }
            }
        }
    </script>
    <style>
        /* Tùy chỉnh thanh cuộn mang phong cách máy móc */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #030712; border-left: 1px solid #1e293b; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 0; }
        
        /* Font hệ thống */
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Inter:wght@400;600;800&display=swap');
        .font-mono-tech { font-family: 'Share Tech Mono', monospace; }
        .font-sans-ui { font-family: 'Inter', sans-serif; }

        /* Animation cảnh báo */
        .scanline {
            width: 100%; height: 100px;
            background: linear-gradient(0deg, rgba(59, 130, 246, 0) 0%, rgba(59, 130, 246, 0.1) 50%, rgba(59, 130, 246, 0) 100%);
            opacity: 0.1; position: absolute; bottom: 100%;
            animation: scanline 8s linear infinite; pointer-events: none; z-index: 50;
        }
        @keyframes scanline { 0% { bottom: 100%; } 100% { bottom: -100px; } }

        /* Góc viền HUD */
        .hud-panel { position: relative; }
        .hud-panel::before, .hud-panel::after {
            content: ''; position: absolute; width: 10px; height: 10px; border: 2px solid transparent; pointer-events: none;
        }
        .hud-panel::before { top: -1px; left: -1px; border-top-color: #3b82f6; border-left-color: #3b82f6; }
        .hud-panel::after { bottom: -1px; right: -1px; border-bottom-color: #3b82f6; border-right-color: #3b82f6; }
        
        .hud-panel-danger::before { border-top-color: #ef4444; border-left-color: #ef4444; }
        .hud-panel-danger::after { border-bottom-color: #ef4444; border-right-color: #ef4444; }

        .pulse-text { animation: blink 2s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    </style>
</head>
<body class="bg-cyber-base text-cyber-text font-sans-ui h-screen flex overflow-hidden relative">

    <div class="absolute inset-0 bg-cyber-grid bg-[size:30px_30px] opacity-20 pointer-events-none"></div>
    <div class="scanline"></div>

    <aside class="w-72 bg-cyber-base/80 backdrop-blur-md border-r border-cyber-border flex flex-col justify-between flex-shrink-0 z-20 relative">
        <div class="absolute right-0 top-0 bottom-0 w-[1px] bg-gradient-to-b from-transparent via-cyber-blue to-transparent opacity-50"></div>
        
        <div>
            <div class="h-24 flex flex-col justify-center px-6 border-b border-cyber-border relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyber-blue to-transparent"></div>
                <h1 class="text-3xl font-black text-white tracking-widest drop-shadow-[0_0_8px_rgba(59,130,246,0.8)]">SHIELD<span class="text-cyber-blue">-AI</span></h1>
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
                <a href="/dashboard" class="group relative px-4 py-3 bg-cyber-blue/10 border border-cyber-blue/30 text-white font-bold transition-all overflow-hidden flex items-center justify-between">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyber-blue"></div>
                    <span class="uppercase tracking-wider text-sm">Command Center</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">[ ACTV ]</span>
                </a>
                
                <a href="{{ route('honeypot') }}" class="px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-medium transition-all flex justify-between items-center">
                    <span class="uppercase tracking-wider text-sm">Cowrie Honeypot</span>
                    <span class="text-[10px] font-mono-tech">L_01</span>
                </a>
                
                <a href="{{ route('ai_analysis') }}" class="px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-medium transition-all flex justify-between items-center">
                    <span class="uppercase tracking-wider text-sm">AI Analysis</span>
                    <span class="text-[10px] font-mono-tech">L_02</span>
                </a>
                
                <a href="{{ route('webshell') }}" class="px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-medium transition-all flex justify-between items-center">
                    <span class="uppercase tracking-wider text-sm">Web Shell Def</span>
                    <span class="text-[10px] font-mono-tech">L_03</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-cyber-border bg-cyber-panel/50 relative">
            <div class="absolute top-0 right-0 p-2 text-[8px] text-cyber-muted font-mono-tech">ID: ADM-001</div>
            <div class="flex items-center gap-3 px-2">
                <div class="h-10 w-10 rounded-sm bg-cyber-base border border-cyber-blue/50 flex items-center justify-center text-cyber-blue font-mono-tech text-lg shadow-[0_0_10px_rgba(59,130,246,0.3)]">
                    A
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Administrator</span>
                    <span class="text-[10px] text-cyber-green font-mono-tech pulse-text">AUTH_VERIFIED [OK]</span>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative z-10">
        
        <header class="h-20 bg-cyber-base/80 backdrop-blur-lg border-b border-cyber-border flex items-center justify-between px-8 z-20">
            <div class="flex flex-col">
                <h2 class="text-lg font-bold text-white tracking-widest uppercase">Global Threat Matrix</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="h-1.5 w-1.5 bg-cyber-green rounded-full pulse-text shadow-[0_0_5px_#10b981]"></span>
                    <span class="text-xs font-mono-tech text-cyber-green tracking-widest uppercase">Network Encrypted // Secured</span>
                    <span class="text-cyber-muted text-xs">|</span>
                    <span class="text-xs font-mono-tech text-cyber-blue">IP_NODE: 127.0.0.1</span>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center font-mono-tech bg-cyber-base border border-cyber-border px-1 py-1 relative hud-panel">
                    <span class="text-[10px] text-cyber-muted px-3 tracking-widest">DEFENSE_PROTOCOL:</span>
                    <form action="{{ route('toggle.auto') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="focus:outline-none flex items-center">
                            @if(config('services.shield.auto_block_enabled', true))
                                <span class="bg-cyber-green/10 text-cyber-green border border-cyber-green px-3 py-1 text-xs font-bold tracking-widest shadow-[0_0_10px_rgba(16,185,129,0.2)] hover:bg-cyber-green/20 transition-all cursor-pointer">AUTO_ON</span>
                            @else
                                <span class="bg-cyber-red/10 text-cyber-red border border-cyber-red px-3 py-1 text-xs font-bold tracking-widest hover:bg-cyber-red/20 transition-all cursor-pointer">MANUAL</span>
                            @endif
                        </button>
                    </form>
                </div>

                <form action="{{ route('clear.logs') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="bg-cyber-red/90 hover:bg-cyber-red text-white font-mono-tech px-6 py-2 text-xs font-bold tracking-[0.2em] uppercase transition-all shadow-[0_0_15px_rgba(239,68,68,0.4)] border border-cyber-red relative overflow-hidden group">
                        <span class="relative z-10">PURGE_DATABANKS</span>
                        <div class="absolute inset-0 h-full w-0 bg-white/20 group-hover:w-full transition-all duration-300 ease-out z-0"></div>
                    </button>
                </form>
            </div>
        </header>

        @if(session('alert'))
            <div class="mx-8 mt-6 border border-cyber-red bg-cyber-red/20 p-4 flex justify-between items-center shadow-[0_0_15px_rgba(239,68,68,0.4)] z-30 relative">
                <div class="flex items-center gap-3">
                    <span class="text-2xl pulse-text">⚠️</span>
                    <span class="font-mono-tech text-white font-bold tracking-widest">{{ session('alert') }}</span>
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-cyber-muted hover:text-white font-mono-tech">
                    [DISMISS]
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-8 mt-6 border border-orange-500 bg-orange-500/20 p-4 flex justify-between items-center shadow-[0_0_15px_rgba(249,115,22,0.4)] z-30 relative">
                <div class="flex items-center gap-3">
                    <span class="text-2xl pulse-text">❌</span>
                    <span class="font-mono-tech text-white font-bold tracking-widest">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-cyber-muted hover:text-white font-mono-tech">
                    [DISMISS]
                </button>
            </div>
        @endif

        <div class="flex-1 overflow-y-auto p-8 relative">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-cyber-panel/60 border border-cyber-red/40 p-5 hud-panel hud-panel-danger backdrop-blur-sm relative overflow-hidden group">
                    <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-cyber-red/10 to-transparent pointer-events-none"></div>
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-cyber-red text-xs font-mono-tech font-bold uppercase tracking-widest">High_Risk_Anomalies</p>
                        <span class="text-[9px] text-cyber-red/50 font-mono-tech border border-cyber-red/30 px-1">LVL: CRITICAL</span>
                    </div>
                    <div class="flex items-end gap-3">
                       <span id="high-risk-count" class="text-5xl font-mono-tech font-black text-white drop-shadow-[0_0_10px_rgba(239,68,68,0.8)]">{{ $highRiskCount }}</span>
                        <span class="text-cyber-muted font-mono-tech text-xs mb-1 uppercase">DETECTED</span>
                    </div>
                    <div class="mt-4 w-full h-[2px] bg-cyber-red/20"><div class="h-full bg-cyber-red w-[85%] pulse-text"></div></div>
                </div>

                <div class="bg-cyber-panel/60 border border-cyber-border p-5 hud-panel backdrop-blur-sm relative">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-cyber-blue text-xs font-mono-tech font-bold uppercase tracking-widest">Payloads_Intercepted</p>
                        <span class="text-[9px] text-cyber-blue/50 font-mono-tech border border-cyber-blue/30 px-1">SRC: WAF</span>
                    </div>
                    <div class="flex items-end gap-3">
                        <span class="text-5xl font-mono-tech font-black text-cyber-text drop-shadow-[0_0_8px_rgba(59,130,246,0.5)]">{{ $webShellBlocked }}</span>
                        <span class="text-cyber-muted font-mono-tech text-xs mb-1 uppercase">FILES NEUTRALIZED</span>
                    </div>
                    <div class="mt-4 flex gap-1">
                        <div class="h-[2px] w-full bg-cyber-blue"></div>
                        <div class="h-[2px] w-4 bg-cyber-blue opacity-50"></div>
                        <div class="h-[2px] w-2 bg-cyber-blue opacity-20"></div>
                    </div>
                </div>

                <div class="bg-cyber-panel/60 border border-cyber-border p-5 hud-panel backdrop-blur-sm relative">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-cyber-text text-xs font-mono-tech font-bold uppercase tracking-widest">Global_Risk_Factor</p>
                        <span class="text-[9px] text-cyber-muted font-mono-tech border border-cyber-border px-1">AVG: 24H</span>
                    </div>
                    <div class="flex items-end gap-1">
                        <span class="text-5xl font-mono-tech font-black text-cyber-text">{{ round($avgRisk, 1) }}</span>
                        <span class="text-2xl font-mono-tech text-cyber-muted">%</span>
                    </div>
                    <div class="mt-4 flex items-end gap-[2px] h-[10px] opacity-40">
                        <div class="w-full bg-cyber-muted h-[20%]"></div><div class="w-full bg-cyber-muted h-[50%]"></div><div class="w-full bg-cyber-muted h-[30%]"></div><div class="w-full bg-cyber-muted h-[80%]"></div><div class="w-full bg-cyber-muted h-[40%]"></div><div class="w-full bg-cyber-muted h-[100%]"></div><div class="w-full bg-cyber-muted h-[60%]"></div><div class="w-full bg-cyber-muted h-[20%]"></div><div class="w-full bg-cyber-muted h-[70%]"></div><div class="w-full bg-cyber-muted h-[40%]"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-cyber-base border border-cyber-border hud-panel flex flex-col p-1 relative shadow-[0_10px_30px_rgba(0,0,0,0.5)]">
                    <div class="absolute top-0 right-4 px-2 py-1 bg-cyber-border text-[8px] font-mono-tech text-cyber-text z-10 tracking-widest">GEO_TRACKING_ONLINE</div>
                    <div class="px-5 py-3 border-b border-cyber-border flex justify-between items-center bg-cyber-panel">
                        <div class="flex items-center gap-2">
                            <span class="text-cyber-blue font-mono-tech text-sm font-bold tracking-widest">/// SPATIAL_ORIGINS</span>
                        </div>
                    </div>
                    <div class="p-1 flex-1 relative bg-[#030712]">
                        <div class="absolute inset-0 bg-cyber-blue opacity-5 pointer-events-none z-10 mix-blend-screen"></div>
                        <div id="attackMap" class="w-full h-[360px] filter contrast-125 sepia-[.2] hue-rotate-[180deg]"></div>
                    </div>
                </div>

                <div class="bg-cyber-base border border-cyber-border hud-panel flex flex-col p-1 relative shadow-[0_10px_30px_rgba(0,0,0,0.5)]">
                    <div class="absolute top-0 right-4 px-2 py-1 bg-cyber-border text-[8px] font-mono-tech text-cyber-text z-10 tracking-widest">DATA_CLASSIFICATION</div>
                    <div class="px-5 py-3 border-b border-cyber-border bg-cyber-panel">
                        <span class="text-cyber-text font-mono-tech text-sm font-bold tracking-widest">/// VECTOR_ANALYSIS</span>
                    </div>
                    <div class="p-6 flex-1 flex items-center justify-center bg-cyber-base relative">
                        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:20px_20px] pointer-events-none"></div>
                        <canvas id="threatChart" class="w-full max-h-[310px] relative z-10"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-cyber-base border border-cyber-border hud-panel flex flex-col p-1 shadow-[0_10px_30px_rgba(0,0,0,0.5)]">
                <div class="px-5 py-3 border-b border-cyber-border bg-cyber-panel flex justify-between items-center">
                    <span class="text-cyber-text font-mono-tech text-sm font-bold tracking-widest">/// LIVE_TRAFFIC_STREAM</span>
                    <span class="text-[10px] text-cyber-muted font-mono-tech pulse-text">RECEIVING DATA...</span>
                </div>
                
                <div class="overflow-x-auto bg-cyber-base">
                    <table class="w-full text-left border-collapse font-mono-tech">
                        <thead>
                            <tr class="bg-cyber-panel/50 border-b border-cyber-border">
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em] w-1/4">Source_IP</th>
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em]">Signature_Type</th>
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em]">Threat_Lvl</th>
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em]">Response_Action</th>
                                <th class="py-3 px-6 text-[10px] text-cyber-blue uppercase tracking-[0.2em] text-right">T_Stamp</th>
                            </tr>
                        </thead>
<tbody id="live-traffic-body" class="divide-y divide-cyber-border/40 text-sm">
    @forelse($logs as $log)
    <tr class="hover:bg-cyber-blue/5 transition-colors group">
        <td class="py-3 px-6 text-cyber-text flex items-center gap-2">
            <span class="text-cyber-muted opacity-0 group-hover:opacity-100 transition-opacity">>></span>
            {{ $log->ip_address }}
        </td>
        <td class="py-3 px-6 text-cyber-muted">{{ $log->attack_type }}</td>
        <td class="py-3 px-6">
            @if($log->risk_score >= 90)
                <span class="text-cyber-red font-bold">[{{ $log->risk_score }}%]</span>
            @elseif($log->risk_score >= 50)
                <span class="text-orange-400 font-bold">[{{ $log->risk_score }}%]</span>
            @else
                <span class="text-cyber-green font-bold">[{{ $log->risk_score }}%]</span>
            @endif
        </td>
        <td class="py-3 px-6">
            @if($log->status === 'Auto-Blocked')
                <span class="text-[10px] font-bold text-cyber-red tracking-widest bg-cyber-red/10 border border-cyber-red/30 px-2 py-1">SYS_BLOCK</span>
            @elseif($log->status === 'Manual-Blocked')
                <span class="text-[10px] font-bold text-orange-400 tracking-widest bg-orange-500/10 border border-orange-500/30 px-2 py-1">ADM_BLOCK</span>
            @else
                <form action="{{ route('block.ip', $log->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-[10px] text-cyber-blue tracking-widest border border-cyber-blue hover:bg-cyber-blue hover:text-white px-3 py-1 transition-all uppercase inline-block text-center cursor-pointer">
                        Exec_Block
                    </button>
                </form>
            @endif
        </td>
        <td class="py-3 px-6 text-right text-xs text-cyber-muted">{{ $log->created_at->diffForHumans() }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="py-12 text-center text-cyber-muted text-xs uppercase tracking-widest">Stream empty. No hostile signatures detected.</td>
    </tr>
    @endforelse
</tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

<script>
        // 1. KHỞI TẠO BẢN ĐỒ CHIẾN THUẬT (Tactical Map)
        var map = L.map('attackMap', { 
            zoomControl: false, 
            attributionControl: false,
            maxBounds: [[-85, -180], [85, 180]] 
        }).setView([20, 0], 2);

        // Sử dụng giao diện bản đồ tối đêm (Dark Mode) để làm nổi bật các điểm tấn công
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { 
            maxZoom: 19 
        }).addTo(map);

        // Tọa độ Server chính (Ví dụ đặt tại Việt Nam)
        const serverPos = [14.0583, 108.2772]; 
        L.circleMarker(serverPos, { 
            color: '#3b82f6', 
            fillColor: '#3b82f6',
            fillOpacity: 1,
            radius: 6 
        }).addTo(map).bindPopup("<b style='color:#000'>SHIELD-AI CORE SERVER</b>");

        // 2. VẼ DỮ LIỆU TẤN CÔNG TỪ DATABASE
        // @json($mapData) sẽ lấy chính xác tọa độ được sinh ra từ code Server của bạn
        const attacks = @json($mapData);

        attacks.forEach(attack => {
            if(attack.latitude && attack.longitude) {
                const hackerPos = [attack.latitude, attack.longitude];
                
                // Kích thước chấm đỏ tỉ lệ thuận với độ nguy hiểm (Risk Score)
                const dotRadius = attack.risk_score / 12; 

                // Vẽ chấm đỏ nhấp nháy tại vị trí hacker
                L.circleMarker(hackerPos, {
                    color: '#ef4444',
                    fillColor: '#ef4444',
                    fillOpacity: 0.6,
                    radius: dotRadius,
                    className: 'pulse-dot' // Class này tạo hiệu ứng nhấp nháy trong CSS
                }).addTo(map);

                // Vẽ đường tia sét tấn công nối từ Hacker về Server
                L.polyline([hackerPos, serverPos], {
                    color: '#ef4444',
                    weight: 1,
                    opacity: 0.2,
                    dashArray: '4, 8'
                }).addTo(map);
            }
        });

        // 3. BIỂU ĐỒ VECTOR ANALYSIS (Giữ nguyên logic của bạn)
        const ctx = document.getElementById('threatChart').getContext('2d');
        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = "'Share Tech Mono', monospace";
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['SCAN', 'BRUTE_F', 'EXPLOIT', 'MALWARE'],
                datasets: [{
                    data: [{{ $scanCount }}, {{ $bruteForceCount }}, {{ $exploitCount }}, {{ $malwareCount }}],
                    backgroundColor: ['rgba(59, 130, 246, 0.8)', 'rgba(239, 68, 68, 0.8)', 'rgba(249, 115, 22, 0.8)', 'rgba(16, 185, 129, 0.8)'],
                    borderColor: ['#3b82f6', '#ef4444', '#f97316', '#10b981'],
                    borderWidth: 1,
                    borderRadius: 0,
                    barPercentage: 0.4
                }]
            },
            options: { 
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#030712',
                        titleColor: '#e2e8f0',
                        bodyColor: '#e2e8f0',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        padding: 10
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(30, 41, 59, 0.5)', drawBorder: false },
                        ticks: { precision: 0 }
                    },
                    x: {
                        grid: { display: false, drawBorder: false }
                    }
                }
            }
        });
    </script>
    <div style="position: fixed; bottom: 20px; right: 20px; background: rgba(0,0,0,0.8); color: #00ff00; padding: 10px 15px; border-radius: 5px; border: 1px solid #00ff00; font-family: monospace; z-index: 9999;">
        <span id="radar-dot" style="color: red; font-weight: bold;">🔴</span> 
        SHIELD-AI RADAR: <span id="countdown">15</span>s
    </div>

<script>
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    const RADAR_INTERVAL = 15; // 15 giây
    // ĐÃ XÓA DÒNG const serverPos = ... Ở ĐÂY VÌ ĐÃ KHAI BÁO Ở TRÊN RỒI

    // 1. HỆ THỐNG TỰ PHỤC HỒI...
    let currentTarget = localStorage.getItem('shieldRadarTarget');
    // ... (Các đoạn code bên dưới giữ nguyên y hệt)
    if (!currentTarget || isNaN(currentTarget)) {
        localStorage.setItem('shieldRadarTarget', Date.now() + (RADAR_INTERVAL * 1000));
    }

    function startGlobalRadar() {
        setInterval(() => {
            let now = Date.now();
            let targetTime = parseInt(localStorage.getItem('shieldRadarTarget'));
            
            // Tính số giây còn lại
            let timeLeft = Math.ceil((targetTime - now) / 1000);

            // NẾU BỊ TRÔI ÂM THỜI GIAN (Do tắt máy tính / sleep) -> TỰ RESET
            if (timeLeft < -2) {
                targetTime = now + (RADAR_INTERVAL * 1000);
                localStorage.setItem('shieldRadarTarget', targetTime);
                timeLeft = RADAR_INTERVAL;
            }

            const radarTimer = document.getElementById('countdown');
            if (radarTimer) radarTimer.innerText = timeLeft > 0 ? timeLeft : 0;

            // KHI ĐẾM VỀ ĐÚNG 0 GIÂY -> BẮN API
            if (timeLeft === 0) {
                // Cập nhật mốc 15s mới ngay lập tức để không bị kẹt
                localStorage.setItem('shieldRadarTarget', now + (RADAR_INTERVAL * 1000));
                if (radarTimer) radarTimer.innerText = "SCAN...";

                fetch("{{ url('/auto-generate-attack') }}")
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            // Cập nhật HUD Số đỏ
                            const highRiskEl = document.getElementById('high-risk-count');
                            if (highRiskEl) highRiskEl.innerText = data.highRiskCount;

                            // Vẽ Map
                            if (data.new_hacker && typeof map !== 'undefined') {
                                const hackerPos = [data.new_hacker.lat, data.new_hacker.lng];
                                L.circleMarker(hackerPos, {color: '#ef4444', radius: data.new_hacker.risk/12, className: 'pulse-dot'}).addTo(map);
                                L.polyline([hackerPos, serverPos], {color: '#ef4444', weight: 1, opacity: 0.2, dashArray: '4,8'}).addTo(map);
                            }

                            // Cập nhật Bảng
                            const tbody = document.getElementById('live-traffic-body');
                            if (tbody && data.logs) {
                                let html = '';
                                const csrfToken = '{{ csrf_token() }}';
                                data.logs.forEach(log => {
                                    let action = (log.status === 'Auto-Blocked' || log.status === 'Manual-Blocked') ? 
                                        `<span class="border border-cyber-red px-2 py-1 text-cyber-red text-[10px] uppercase">${log.status === 'Auto-Blocked' ? 'SYS_BLOCK' : 'ADM_BLOCK'}</span>` : 
                                        `<form action="{{ url('/block-ip') }}/${log.id}" method="POST" class="inline"><input type="hidden" name="_token" value="${csrfToken}"><button type="submit" class="border border-cyber-blue px-2 py-1 text-cyber-blue text-[10px] uppercase cursor-pointer">EXEC_BLOCK</button></form>`;
                                    
                                    let riskColor = log.risk_score >= 90 ? 'text-cyber-red' : (log.risk_score >= 50 ? 'text-orange-400' : 'text-cyber-green');

                                    html += `<tr class="border-b border-cyber-border/40 hover:bg-cyber-blue/5">
                                        <td class="py-3 px-6 text-white font-mono-tech">>> ${escapeHtml(String(log.ip_address))}</td>
                                        <td class="py-3 px-6 text-cyber-muted">${escapeHtml(String(log.attack_type))}</td>
                                        <td class="py-3 px-6 ${riskColor} font-bold">[${escapeHtml(String(log.risk_score))}%]</td>
                                        <td class="py-3 px-6">${action}</td>
                                        <td class="py-3 px-6 text-right text-cyber-muted">just now</td>
                                    </tr>`;
                                });
                                tbody.innerHTML = html;
                            }
                        }
                    })
                    .catch(err => console.log("Radar đang chờ nhịp..."));
            }
        }, 1000);
    }

    startGlobalRadar();
</script>
</body>
</html>