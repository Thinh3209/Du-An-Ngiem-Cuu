<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | L_04: SYSTEM_LOGS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { cyber: { base: '#030712', panel: '#0f172a', border: '#1e293b', blue: '#3b82f6', text: '#e2e8f0', muted: '#64748b', green: '#10b981' }, void: '#010308', surface: '#050a14', grid: '#0a192f', neon: { blue: '#00f0ff', red: '#ff003c', green: '#00ff41', alert: '#ffb000' } } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #010308; border-left: 1px solid #1e293b; }
        ::-webkit-scrollbar-thumb { background: #00f0ff; }
        .font-mono-tech { font-family: 'Share Tech Mono', monospace; }
        .font-sans-ui { font-family: 'Inter', sans-serif; }
        .pulse-text { animation: blink 2s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
        .crt::before { content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03)); z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none; opacity: 0.3; }
        .cyber-border { position: relative; border: 1px solid #00f0ff; box-shadow: 0 0 10px rgba(0, 240, 255, 0.1); }
        .glitch-text { position: relative; display: inline-block; }
        .glitch-text::before, .glitch-text::after { content: attr(data-text); position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.8; }
        .glitch-text::before { left: 2px; text-shadow: -1px 0 red; animation: glitch-anim-1 3s infinite linear alternate-reverse; }
        .glitch-text::after { left: -2px; text-shadow: -1px 0 blue; animation: glitch-anim-2 2s infinite linear alternate-reverse; }
        @keyframes glitch-anim-1 { 0% { clip-path: inset(20% 0 80% 0); } 100% { clip-path: inset(30% 0 20% 0); } }
        @keyframes glitch-anim-2 { 0% { clip-path: inset(10% 0 60% 0); } 100% { clip-path: inset(5% 0 80% 0); } }
    </style>
</head>
<body class="bg-cyber-base text-cyber-text font-sans-ui h-screen flex flex-col lg:flex-row overflow-hidden relative">

    <aside id="sidebar" class="hidden lg:flex flex-col w-full lg:w-72 bg-cyber-base/95 lg:bg-cyber-base border-r border-cyber-border flex-shrink-0 z-40 absolute lg:relative h-[calc(100vh-4rem)] lg:h-screen top-16 lg:top-0 left-0">
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

            <nav class="mt-8 flex flex-col gap-2 px-4">
                <a href="/dashboard" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all flex items-center justify-between">
                    <span class="uppercase tracking-wider text-sm">Command Center</span>
                </a>
                <a href="{{ route('honeypot') }}" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all flex items-center justify-between">
                    <span class="uppercase tracking-wider text-sm">Cowrie Honeypot</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">L_01</span>
                </a>
                <a href="{{ route('ai_analysis') }}" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all flex items-center justify-between">
                    <span class="uppercase tracking-wider text-sm">AI Analysis</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">L_02</span>
                </a>
                <a href="{{ route('webshell') }}" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all flex items-center justify-between">
                    <span class="uppercase tracking-wider text-sm">Infra Matrix</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">L_03</span>
                </a>
                <a href="{{ route('system_logs') }}" class="group relative px-4 py-3 bg-cyber-blue/10 border border-cyber-blue/30 text-white font-bold transition-all flex items-center justify-between">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyber-blue"></div>
                    <span class="uppercase tracking-wider text-sm">System Logs</span>
                    <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">[ ACTV ]</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-cyber-border bg-cyber-panel/50 relative mt-auto">
            <div class="flex items-center gap-3 px-2">
                <div class="h-10 w-10 rounded-sm bg-cyber-base border border-cyber-blue/50 flex items-center justify-center text-cyber-blue font-mono-tech text-lg shadow-[0_0_10px_rgba(59,130,246,0.3)]">A</div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Administrator</span>
                    <span class="text-[10px] text-neon-green font-mono-tech pulse-text">AUTH_VERIFIED [OK]</span>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative z-10 overflow-y-auto bg-void text-neon-blue font-mono crt">
        <div class="fixed inset-0 bg-[linear-gradient(to_right,#0a192f_1px,transparent_1px),linear-gradient(to_bottom,#0a192f_1px,transparent_1px)] bg-[size:40px_40px] opacity-20 z-[0] pointer-events-none"></div>

        <div class="p-4 md:p-8 relative z-10 w-full mx-auto">
            <header class="flex flex-col justify-between items-start border-b border-neon-blue/30 pb-4 mb-6 relative gap-2">
                <div class="absolute -bottom-[1px] left-0 w-1/4 h-[2px] bg-neon-blue shadow-[0_0_10px_#00f0ff]"></div>
                <div class="flex items-center gap-2 text-[10px] tracking-[0.3em] opacity-80">
                    <span class="text-neon-alert pulse-text">● GLOBAL_AUDIT_TRAIL</span>
                    <span>// THREAT_ARCHIVE</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black uppercase tracking-widest text-white drop-shadow-[0_0_10px_rgba(0,240,255,0.5)] glitch-text" data-text="SYSTEM_LOGS">SYSTEM_LOGS</h1>
            </header>

            <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <form action="{{ route('system_logs') }}" method="GET" class="w-full md:w-2/3 flex items-center gap-2">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Enter IP Address, Attack Type or Target..." 
                               class="w-full bg-black/50 border border-neon-blue/50 text-neon-blue px-4 py-3 outline-none focus:border-neon-blue focus:shadow-[0_0_10px_rgba(0,240,255,0.3)] font-mono-tech text-[12px] md:text-sm transition-all" autocomplete="off">
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 opacity-50">
                            [ _ ]
                        </div>
                    </div>
                    <button type="submit" class="bg-neon-blue/20 text-neon-blue border border-neon-blue hover:bg-neon-blue hover:text-white px-6 py-3 text-[12px] md:text-sm font-bold tracking-widest uppercase transition-all shadow-[0_0_10px_rgba(0,240,255,0.2)]">
                        SCAN
                    </button>
                    @if(!empty($search))
                        <a href="{{ route('system_logs') }}" class="bg-gray-800 text-gray-400 border border-gray-600 hover:text-white px-4 py-3 text-[12px] md:text-sm font-bold tracking-widest uppercase transition-all">
                            CLEAR
                        </a>
                    @endif
                </form>

                <form action="{{ url('/clear-logs') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="bg-neon-red/20 text-neon-red border border-neon-red hover:bg-neon-red hover:text-white px-4 py-2 text-[10px] md:text-[12px] font-bold tracking-widest uppercase transition-all shadow-[0_0_10px_rgba(255,0,60,0.3)]">
                        PURGE_DATABANKS
                    </button>
                </form>
            </div>

            @if(session('alert'))
                <div class="mb-4 border border-neon-green bg-neon-green/20 p-3 text-neon-green font-mono-tech text-[12px] uppercase tracking-widest flex justify-between">
                    <span>[OK] {{ session('alert') }}</span>
                    <button onclick="this.parentElement.style.display='none'">[X]</button>
                </div>
            @endif

            <div class="cyber-border bg-surface/80 p-1 backdrop-blur-sm shadow-2xl overflow-hidden w-full relative">
                <div class="bg-grid/40 border-b border-neon-blue/20 p-1 w-full overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap font-mono-tech">
                        <thead class="bg-black/60 text-neon-blue text-[9px] md:text-[10px] uppercase tracking-[0.2em]">
                            <tr>
                                <th class="p-4 font-bold">T_Stamp (Time)</th>
                                <th class="p-4 font-bold">Source_IP</th>
                                <th class="p-4 font-bold text-center">Geo_Location</th>
                                <th class="p-4 font-bold">Action / Target</th>
                                <th class="p-4 font-bold text-center">Risk</th>
                                <th class="p-4 font-bold text-center">Status</th>
                                <th class="p-4 font-bold text-right">Command</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neon-blue/10 text-[11px] md:text-[12px]">
                            @forelse($logs as $log)
                            <tr class="hover:bg-neon-blue/10 transition-colors group">
                                <td class="p-4 text-white/50">{{ $log->created_at->format('H:i:s d/m/Y') }}</td>
                                <td class="p-4 text-white font-bold tracking-wider">
                                    <span class="opacity-0 group-hover:opacity-100 text-neon-blue mr-2">></span>{{ $log->ip_address }}
                                </td>
                                
                                <td class="py-3 px-4 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="geo-locator text-[10px] uppercase tracking-widest text-neon-blue mb-1" data-ip="{{ $log->ip_address }}">
                                            [ TRACING_NODE... ]
                                        </span>
                                        @if($log->latitude && $log->longitude)
                                            <a href="https://www.google.com/maps?q={{ $log->latitude }},{{ $log->longitude }}" 
                                               target="_blank" 
                                               class="flex flex-col items-center text-neon-blue hover:text-neon-green hover:underline group-map"
                                               title="Click to initiate Satellite Tracking">
                                                <span class="text-[9px] text-white/50 hover:text-neon-green/50">LAT: {{ $log->latitude }} | LON: {{ $log->longitude }}</span>
                                                <span class="mt-1 text-[8px] tracking-widest bg-neon-blue/10 px-2 rounded-sm hover:bg-neon-green/20">[ TRACE_UPLINK ]</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="p-4 text-neon-blue/70 truncate max-w-[200px]">
                                    {{ $log->attack_type }} 
                                </td>
                                <td class="p-4 text-center">
                                    @if($log->risk_score >= 90)
                                        <span class="text-neon-red font-bold">[{{ $log->risk_score }}%]</span>
                                    @elseif($log->risk_score >= 50)
                                        <span class="text-neon-alert font-bold">[{{ $log->risk_score }}%]</span>
                                    @else
                                        <span class="text-neon-green font-bold">[{{ $log->risk_score }}%]</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if(in_array($log->status, ['Auto-Blocked', 'Manual-Blocked', 'sys_block']))
                                        <span class="text-neon-red text-[9px] uppercase font-bold tracking-widest">BLOCKED</span>
                                    @elseif($log->status == 'Unblocked')
                                        <span class="text-neon-green text-[9px] uppercase font-bold tracking-widest">SAFE</span>
                                    @else
                                        <span class="text-neon-alert text-[9px] uppercase font-bold tracking-widest">PENDING</span>
                                    @endif
                                </td>
                                
                                <td class="p-4 text-right">
                                    @if(in_array($log->status, ['Auto-Blocked', 'Manual-Blocked', 'sys_block']))
                                        <a href="{{ url('/unblock-ip/' . $log->id) }}" class="border border-neon-green text-neon-green hover:bg-neon-green hover:text-black px-3 py-2 text-[9px] uppercase font-bold tracking-widest transition-all inline-block w-full text-center">
                                            RESTORE_ACCESS
                                        </a>
                                    @else
                                        <a href="{{ url('/block-ip/' . $log->id) }}" class="border border-neon-red text-neon-red hover:bg-neon-red hover:text-white px-3 py-2 text-[9px] uppercase font-bold tracking-widest transition-all inline-block w-full text-center">
                                            EXEC_BLOCK
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-neon-blue/40 tracking-widest uppercase text-[10px]">
                                    <div class="animate-pulse">No matches found for "{{ $search }}".</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-black/40 border-t border-neon-blue/20">
                    {{ $logs->appends(['search' => $search])->links('pagination::tailwind') }}
                </div>
            </div>
            <div class="h-10"></div>
        </div>
    </main>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Gom tất cả các IP độc nhất (không trùng lặp) có trong bảng
            const ipNodes = document.querySelectorAll('.geo-locator');
            const ips = [...new Set(Array.from(ipNodes).map(node => node.getAttribute('data-ip')))];
            
            if (ips.length > 0) {
                // 🛡️ NÂNG CẤP API: Ép lấy District (Quận/Huyện) và hiển thị Tiếng Việt (lang=vi)
                fetch('http://ip-api.com/batch?fields=status,countryCode,regionName,city,district,query&lang=vi', {
                    method: 'POST',
                    body: JSON.stringify(ips)
                })
                .then(res => res.json())
                .then(data => {
                    const geoMap = {};
                    data.forEach(info => {
                        if(info.status === 'success') {
                            // Lắp ghép mảng vị trí: Quận/Huyện -> Thành Phố -> Quốc Gia
                            let locArray = [];
                            if (info.district) locArray.push(info.district); // Lấy Quận/Huyện
                            if (info.city) locArray.push(info.city);         // Lấy Thành phố
                            else if (info.regionName) locArray.push(info.regionName); // Lấy Tỉnh (nếu ko có TP)
                            
                            locArray.push(info.countryCode); // Lấy Mã Quốc Gia (VN)
                            
                            // Nối lại thành chuỗi (VD: Quận Hoàn Kiếm - Hà Nội - VN)
                            geoMap[info.query] = locArray.join(' - ');
                        } else {
                            geoMap[info.query] = 'UNKNOWN_REGION';
                        }
                    });

                    // Điền vị trí vào bảng
                    setTimeout(() => {
                        ipNodes.forEach(node => {
                            const ip = node.getAttribute('data-ip');
                            node.innerText = geoMap[ip] || 'UNKNOWN_REGION';
                            node.classList.remove('animate-pulse', 'text-white/40');
                            node.classList.add('text-neon-blue', 'font-bold');
                        });
                    }, 500); 
                })
                .catch(err => {
                    ipNodes.forEach(node => {
                        node.innerText = 'TRACE_FAILED';
                        node.classList.remove('animate-pulse');
                    });
                });
            }
        });
    </script>
</body>
</html>