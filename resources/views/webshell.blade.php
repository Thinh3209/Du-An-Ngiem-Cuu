<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Layer 3: Web Shell Defense</title>
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
        /* CRT & Grid Sync with L1 & L2 */
        body { background-color: #010308; margin: 0; overflow-x: hidden; font-family: 'Share Tech Mono', monospace; color: #00f0ff; }
        .crt::before {
            content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
            z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none; opacity: 0.3;
        }

        /* Cyber Borders Sync */
        .cyber-border {
            position: relative; border: 1px solid #00f0ff;
            box-shadow: 0 0 10px rgba(0, 240, 255, 0.1);
        }
        .cyber-border::before, .cyber-border::after {
            content: ''; position: absolute; width: 12px; height: 12px; border: 2px solid #00f0ff; pointer-events: none;
        }
        .cyber-border::before { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .cyber-border::after { bottom: -2px; right: -2px; border-left: none; border-top: none; }

        /* Danger Border for Malware */
        .cyber-border-danger { border-color: #ff003c; box-shadow: 0 0 10px rgba(255, 0, 60, 0.2); }
        .cyber-border-danger::before, .cyber-border-danger::after { border-color: #ff003c; }

        /* Glitch Effect Sync */
        .glitch-text { position: relative; display: inline-block; }
        .glitch-text::before, .glitch-text::after {
            content: attr(data-text); position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.8;
        }
        .glitch-text::before { left: 2px; text-shadow: -1px 0 red; animation: glitch-anim-1 3s infinite linear alternate-reverse; }
        .glitch-text::after { left: -2px; text-shadow: -1px 0 blue; animation: glitch-anim-2 2s infinite linear alternate-reverse; }
        @keyframes glitch-anim-1 { 0% { clip-path: inset(20% 0 80% 0); } 100% { clip-path: inset(30% 0 20% 0); } }
        @keyframes glitch-anim-2 { 0% { clip-path: inset(10% 0 60% 0); } 100% { clip-path: inset(5% 0 80% 0); } }

        .pulse-text { animation: blink 2s infinite; }
        @keyframes blink { 50% { opacity: 0.3; } }
        
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #010308; }
        ::-webkit-scrollbar-thumb { background: #ff003c; }
    </style>
</head>
<body class="crt">
    <div class="fixed inset-0 bg-[linear-gradient(to_right,#0a192f_1px,transparent_1px),linear-gradient(to_bottom,#0a192f_1px,transparent_1px)] bg-[size:40px_40px] opacity-20 z-[-1]"></div>

    <div class="max-w-[1500px] mx-auto p-6 md:p-10 relative z-10">
        
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end border-b border-neon-blue/30 pb-6 mb-8 relative">
            <div class="absolute -bottom-[1px] left-0 w-1/4 h-[2px] bg-neon-blue shadow-[0_0_10px_#00f0ff]"></div>
            
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-3 text-[10px] tracking-[0.3em] opacity-60">
                    <span>MALWARE_SCAN: ACTIVE</span>
                    <span class="text-neon-red pulse-text">● THREAT_MONITORING</span>
                </div>
                <h1 class="text-4xl font-black uppercase tracking-widest text-white drop-shadow-[0_0_10px_rgba(0,240,255,0.5)] glitch-text" data-text="WEB_SHELL_DEFENSE">
                    WEB_SHELL_DEFENSE
                </h1>
                <p class="text-[10px] text-neon-blue/70 tracking-[0.2em]">L3_FILE_INTEGRITY_SHIELD // WEBSHELL_DETECTION_GRID</p>
            </div>

            <a href="/dashboard" class="mt-6 lg:mt-0 border border-neon-blue px-6 py-2 hover:bg-neon-blue hover:text-void transition-all duration-300 font-bold tracking-[0.2em] text-xs flex items-center gap-2">
                RETURN_TO_COMMAND
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div class="cyber-border bg-grid/20 p-6 flex flex-col justify-between overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 text-4xl font-black">SCAN</div>
                <p class="text-[10px] uppercase text-neon-blue tracking-widest mb-4">Monitoring Status</p>
                <div class="flex items-center gap-4">
                    <div class="h-12 w-1 bg-neon-green shadow-[0_0_10px_#00ff41]"></div>
                    <p class="text-2xl font-bold text-white tracking-tighter">REAL-TIME_WATCH <span class="text-[10px] text-neon-green ml-2 tracking-widest pulse-text">[ SECURE ]</span></p>
                </div>
            </div>
            
            <div class="cyber-border cyber-border-danger bg-neon-red/5 p-6 flex flex-col justify-between overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 text-4xl font-black text-neon-red">LOCK</div>
                <p class="text-[10px] uppercase text-neon-red tracking-widest mb-4">Quarantined Entities</p>
                <div class="flex items-baseline gap-4">
                    <span class="text-5xl font-black text-white drop-shadow-[0_0_10px_rgba(255,0,60,0.5)]">{{ $quarantinedCount }}</span>
                    <span class="text-[10px] text-neon-red font-bold uppercase tracking-widest">Isolated Files</span>
                </div>
            </div>
        </div>

        <div class="mb-4 text-[11px] tracking-widest uppercase opacity-60 flex justify-between items-center">
            <span>/// Suspicious_Entity_Registry</span>
            <span class="text-neon-red">Action: System_Lockdown</span>
        </div>

        <div class="cyber-border bg-surface/80 p-1 backdrop-blur-sm shadow-2xl overflow-hidden">
            <div class="bg-grid/40 border-b border-neon-blue/20 p-1">
                <table class="w-full text-left">
                    <thead class="bg-black/60 text-neon-blue text-[10px] uppercase tracking-[0.2em]">
                        <tr>
                            <th class="p-5 font-bold">Entity_Name</th>
                            <th class="p-5 font-bold">Source_Path</th>
                            <th class="p-5 font-bold">Detection_Signature</th>
                            <th class="p-5 font-bold text-right">Containment_Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neon-blue/10 text-[12px] font-mono">
                        @forelse($badFiles as $file)
                        <tr class="hover:bg-neon-red/10 transition-colors group">
                            <td class="p-5 text-neon-red font-bold tracking-wider">
                                <span class="opacity-0 group-hover:opacity-100 mr-2">></span>{{ $file->file_name }}
                            </td>
                            <td class="p-5 text-neon-blue/40 italic break-all max-w-xs">
                                {{ $file->file_path }}
                            </td>
                            <td class="p-5">
                                <span class="border border-neon-red/50 px-3 py-1 bg-neon-red/10 text-neon-red text-[10px] uppercase font-bold tracking-widest shadow-[0_0_5px_rgba(255,0,60,0.2)]">
                                    {{ $file->detected_type }}
                                </span>
                            </td>
                            <td class="p-5 text-right">
                                <span class="bg-void border border-neon-blue/20 text-white/50 px-3 py-1 text-[9px] font-bold tracking-widest uppercase">
                                    CHMOD_000 [ISOLATED]
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <div class="w-20 h-[2px] bg-neon-green/30 animate-pulse"></div>
                                    <p class="text-2xl font-black text-neon-green tracking-[0.4em] glitch-text" data-text="SECTOR_SECURE">SECTOR_SECURE</p>
                                    <p class="text-[10px] text-neon-green/40 tracking-widest uppercase">No malicious shell signatures detected in directory.</p>
                                    <div class="w-20 h-[2px] bg-neon-green/30 animate-pulse"></div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-between items-center opacity-30 text-[8px] tracking-[0.5em] uppercase">
            <span>Integrity_Verified_v3.0</span>
            <span>File_Shield_Active</span>
            <span>X-UPLINK: SECURE</span>
        </div>
    </div>
</body>
</html>