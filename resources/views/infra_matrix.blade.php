<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Infra_Matrix L_03</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        tailwind.config = { 
            theme: { 
                extend: { 
                    colors: { 
                        cyber: { base: '#030712', panel: '#0f172a', border: '#1e293b', blue: '#3b82f6', text: '#e2e8f0', muted: '#64748b' }, 
                        void: '#010308', surface: '#050a14', 
                        neon: { blue: '#00f0ff', red: '#ff003c', green: '#00ff41', alert: '#ffb000' } 
                    } 
                } 
            } 
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        /* Base Styles & Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #010308; border-left: 1px solid #1e293b; }
        ::-webkit-scrollbar-thumb { background: #00f0ff; }
        
        .font-mono-tech { font-family: 'Share Tech Mono', monospace; }
        .font-sans-ui { font-family: 'Inter', sans-serif; }
        
        /* Animations */
        .pulse-text { animation: blink 2s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
        
        .crt::before { content: " "; display: block; position: fixed; top: 0; left: 0; bottom: 0; right: 0; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03)); z-index: 50; background-size: 100% 2px, 3px 100%; pointer-events: none; opacity: 0.15; }
        
        /* Cyberpunk Box Styles */
        .cyber-border { position: relative; border: 1px solid #00f0ff; box-shadow: 0 0 10px rgba(0, 240, 255, 0.1); background-color: rgba(5, 10, 20, 0.85); }
        .cyber-border::before, .cyber-border::after { content: ''; position: absolute; width: 12px; height: 12px; border: 2px solid #00f0ff; pointer-events: none; }
        .cyber-border::before { top: -2px; left: -2px; border-right: none; border-bottom: none; }
        .cyber-border::after { bottom: -2px; right: -2px; border-left: none; border-top: none; }
        
        /* Custom Terminal Scrollbar */
        .terminal-scroll::-webkit-scrollbar { width: 6px; }
        .terminal-scroll::-webkit-scrollbar-track { background: #030712; border-left: 1px solid #1e293b; }
        .terminal-scroll::-webkit-scrollbar-thumb { background: #10b981; border-radius: 2px; box-shadow: 0 0 5px #10b981; }
        .terminal-scroll::-webkit-scrollbar-thumb:hover { background: #059669; }
        
        /* Gradient Fade for Logs */
        .log-container { -webkit-mask-image: linear-gradient(to bottom, black 80%, transparent 100%); mask-image: linear-gradient(to bottom, black 80%, transparent 100%); }
    </style>
</head>

<body class="bg-cyber-base text-cyber-text font-sans-ui h-screen flex flex-col lg:flex-row overflow-hidden relative crt">

    <aside id="sidebar" class="hidden lg:flex flex-col w-full lg:w-72 bg-cyber-base border-r border-cyber-border flex-shrink-0 z-40 absolute lg:relative h-full top-0 left-0">
        <div class="h-24 flex flex-col justify-center px-6 border-b border-cyber-border relative overflow-hidden">
            <h1 class="text-3xl font-black text-white tracking-widest drop-shadow-[0_0_8px_rgba(59,130,246,0.8)]">Q3T<span class="text-cyber-blue">-MLSFS</span></h1>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-[10px] text-cyber-blue font-mono-tech tracking-[0.2em] uppercase">SYS.CORE // V1.0.9</span>
                <span class="h-1 w-1 bg-cyber-blue rounded-full pulse-text"></span>
            </div>
        </div>

        <nav class="mt-8 flex flex-col gap-2 px-4 flex-1">
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
            <a href="{{ route('webshell') }}" class="group relative px-4 py-3 bg-cyber-blue/10 border border-cyber-blue/30 text-white font-bold transition-all flex items-center justify-between">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-cyber-blue"></div>
                <span class="uppercase tracking-wider text-sm">Infra Matrix</span>
                <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">[ ACTV ]</span>
            </a>
            <a href="{{ route('system_logs') }}" class="group relative px-4 py-3 border border-transparent text-cyber-muted hover:border-cyber-border hover:bg-cyber-panel/50 font-bold transition-all flex items-center justify-between">
                <span class="uppercase tracking-wider text-sm">System Logs</span>
                <span class="text-[10px] text-cyber-blue font-mono-tech opacity-70">L_04</span>
            </a>
        </nav>

        <div class="p-4 border-t border-cyber-border bg-cyber-panel/50 mt-auto">
            <div class="flex items-center gap-3 px-2">
                <div class="h-10 w-10 rounded-sm bg-cyber-base border border-cyber-blue/50 flex items-center justify-center text-cyber-blue font-mono-tech text-lg shadow-[0_0_10px_rgba(59,130,246,0.3)]">A</div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Administrator</span>
                    <span class="text-[10px] text-neon-green font-mono-tech pulse-text">AUTH_VERIFIED [OK]</span>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative z-10 overflow-y-auto bg-void text-neon-blue font-mono">
        <div class="fixed inset-0 bg-[linear-gradient(to_right,#0a192f_1px,transparent_1px),linear-gradient(to_bottom,#0a192f_1px,transparent_1px)] bg-[size:40px_40px] opacity-20 z-[0] pointer-events-none"></div>

        <div class="p-4 md:p-8 relative z-10 w-full max-w-7xl mx-auto flex-1">
            
            <header class="flex flex-col justify-between items-start border-b border-neon-blue/30 pb-4 mb-6 relative gap-2">
                <div class="absolute -bottom-[1px] left-0 w-1/4 h-[2px] bg-neon-blue shadow-[0_0_10px_#00f0ff]"></div>
                <div class="flex items-center gap-2 text-[10px] tracking-[0.3em] opacity-80">
                    <span class="text-neon-green pulse-text">● LIVE_TELEMETRY</span>
                    <span>// DATACENTER_UPLINK</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black uppercase tracking-widest text-white drop-shadow-[0_0_10px_rgba(0,240,255,0.5)]">INFRA_MATRIX</h1>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="cyber-border p-5 flex flex-col items-center justify-between backdrop-blur-sm min-h-[220px]">
                    <p class="text-[10px] tracking-widest text-white/50 uppercase w-full text-left mb-2">Core_Processing</p>
                    <div class="w-24 h-24 relative my-2">
                        <canvas id="cpuChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center flex-col mt-2">
                            <span id="cpuText" class="text-xl font-bold text-white drop-shadow-[0_0_8px_#fff]">0%</span>
                        </div>
                    </div>
                    <div class="w-full text-[9px] font-mono-tech text-white/60 space-y-1 border-t border-neon-blue/20 pt-3 mt-auto">
                        <div class="flex justify-between"><span>Load (1/5/15m):</span> <span id="loadAvg" class="text-white">0.0 / 0.0 / 0.0</span></div>
                        <div id="coreUsageContainer" class="flex justify-between mt-1 text-neon-blue">
                            <span class="animate-pulse">Scanning cores...</span>
                        </div>
                    </div>
                </div>
                
                <div class="cyber-border p-5 flex flex-col items-center justify-between backdrop-blur-sm min-h-[220px]">
                    <p class="text-[10px] tracking-widest text-white/50 uppercase w-full text-left mb-2">Memory_Alloc</p>
                    <div class="w-24 h-24 relative my-2">
                        <canvas id="ramChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center flex-col mt-2">
                            <span id="ramText" class="text-xl font-bold text-white drop-shadow-[0_0_8px_#fff]">0%</span>
                        </div>
                    </div>
                    <div class="w-full text-[9px] font-mono-tech text-white/60 space-y-1 border-t border-neon-blue/20 pt-3 mt-auto">
                        <div class="flex justify-between"><span>Used:</span> <span id="ramUsed" class="text-white">0 MB</span></div>
                        <div class="flex justify-between"><span>Total:</span> <span id="ramTotal" class="text-white">0 MB</span></div>
                        <div class="flex justify-between"><span>Available:</span> <span id="ramAvail" class="text-neon-green">0 MB</span></div>
                    </div>
                </div>

                <div class="cyber-border p-5 flex flex-col items-center justify-between backdrop-blur-sm min-h-[220px]">
                    <p class="text-[10px] tracking-widest text-white/50 uppercase w-full text-left mb-2">Storage_IO</p>
                    <div class="w-24 h-24 relative my-2">
                        <canvas id="diskChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center flex-col mt-2">
                            <span id="diskText" class="text-xl font-bold text-white drop-shadow-[0_0_8px_#fff]">0%</span>
                        </div>
                    </div>
                    <div class="w-full text-[9px] font-mono-tech text-white/60 space-y-1 border-t border-neon-blue/20 pt-3 mt-auto">
                        <div class="flex justify-between"><span>Used Space:</span> <span id="diskUsed" class="text-white">0 GB</span></div>
                        <div class="flex justify-between"><span>Total Space:</span> <span id="diskTotal" class="text-white">0 GB</span></div>
                        <div class="flex justify-between"><span>Mount:</span> <span class="text-neon-green">/ (Root)</span></div>
                    </div>
                </div>

            </div>

            <div class="cyber-border p-6 mb-8 backdrop-blur-sm">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-[12px] tracking-widest text-white font-bold uppercase">Network_Traffic_Stream</p>
                    <div class="flex gap-4 text-[10px] tracking-widest font-bold">
                        <span class="text-neon-green">RX (IN): <span id="rxSpeed">0.0</span> KB/s</span>
                        <span class="text-neon-blue">TX (OUT): <span id="txSpeed">0.0</span> KB/s</span>
                    </div>
                </div>
                <div class="w-full h-[200px]">
                    <canvas id="networkChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                <div class="cyber-border p-5 backdrop-blur-sm relative border-t-2 border-t-neon-blue h-[350px] flex flex-col">
                    <div class="absolute top-0 right-0 bg-neon-blue text-black text-[9px] px-3 py-1 font-bold tracking-widest">LIVE_TAIL</div>
                    <div class="flex-1 overflow-y-auto terminal-scroll mt-3 pr-2 font-mono-tech text-[11px] leading-relaxed text-neon-green log-container" id="terminalLogs">
                        <div class="mb-1">> [SYS] Initializing SHIELD-AI Kernel...</div>
                    </div>
                </div>

                <div class="cyber-border p-5 backdrop-blur-sm relative border-t-2 border-t-neon-alert h-[350px] flex flex-col">
                    <div class="absolute top-0 right-0 bg-neon-alert text-black text-[9px] px-3 py-1 font-bold tracking-widest">TOP_PROCESSES</div>
                    <div class="flex-1 overflow-y-auto terminal-scroll mt-3 pr-2 w-full">
                        <table class="w-full text-left text-[11px] text-neon-blue whitespace-nowrap font-mono-tech">
                            <thead class="text-white/50 border-b border-neon-blue/30 sticky top-0 bg-[#050a14] z-10">
                                <tr>
                                    <th class="pb-2 font-normal">PID</th>
                                    <th class="pb-2 font-normal">USER</th>
                                    <th class="pb-2 font-normal text-white">COMMAND</th>
                                    <th class="pb-2 font-normal text-neon-red text-right">%CPU</th>
                                    <th class="pb-2 font-normal text-neon-green text-right">%RAM</th>
                                </tr>
                            </thead>
                            <tbody id="processTable" class="divide-y divide-neon-blue/10 font-bold">
                                <tr><td colspan="5" class="pt-4 text-center animate-pulse text-white/50">Scanning processes...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="h-10"></div>
        </div>
    </main>

    <script>
        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = "'Share Tech Mono', monospace";
        const chartOptions = { cutout: '75%', responsive: true, maintainAspectRatio: false, plugins: { tooltip: { enabled: false }, legend: { display: false } }, animation: { duration: 500 } };
        
        const cpuCtx = document.getElementById('cpuChart').getContext('2d');
        const cpuChart = new Chart(cpuCtx, { type: 'doughnut', data: { datasets: [{ data: [0, 100], backgroundColor: ['#00f0ff', 'rgba(0, 240, 255, 0.1)'], borderWidth: 0 }] }, options: chartOptions });

        const ramCtx = document.getElementById('ramChart').getContext('2d');
        const ramChart = new Chart(ramCtx, { type: 'doughnut', data: { datasets: [{ data: [0, 100], backgroundColor: ['#ffb000', 'rgba(255, 176, 0, 0.1)'], borderWidth: 0 }] }, options: chartOptions });

        const diskCtx = document.getElementById('diskChart').getContext('2d');
        const diskChart = new Chart(diskCtx, { type: 'doughnut', data: { datasets: [{ data: [0, 100], backgroundColor: ['#00ff41', 'rgba(0, 255, 65, 0.1)'], borderWidth: 0 }] }, options: chartOptions });

        const netCtx = document.getElementById('networkChart').getContext('2d');
        const maxDataPoints = 20;
        const netChart = new Chart(netCtx, {
            type: 'line',
            data: {
                labels: Array(maxDataPoints).fill(''),
                datasets: [
                    { label: 'RX', borderColor: '#00ff41', backgroundColor: 'rgba(0, 255, 65, 0.1)', borderWidth: 2, pointRadius: 0, fill: true, tension: 0.4, data: Array(maxDataPoints).fill(0) },
                    { label: 'TX', borderColor: '#00f0ff', backgroundColor: 'rgba(0, 240, 255, 0.1)', borderWidth: 2, pointRadius: 0, fill: true, tension: 0.4, data: Array(maxDataPoints).fill(0) }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: 'rgba(30, 41, 59, 0.3)' }, ticks: { callback: function(value) { return value + ' KB/s'; } } }, x: { grid: { display: false } } }, animation: false }
        });

        let prevRx = 0, prevTx = 0, lastTime = Date.now();

        function fetchInfraData() {
            fetch('/api/infra-data')
                .then(res => res.json())
                .then(data => {
                    // CPU
                    cpuChart.data.datasets[0].data = [data.cpu, 100 - data.cpu];
                    cpuChart.data.datasets[0].backgroundColor[0] = data.cpu > 80 ? '#ff003c' : '#00f0ff';
                    cpuChart.update();
                    document.getElementById('cpuText').innerText = data.cpu + '%';
                    
                    if (data.load_avg && document.getElementById('loadAvg')) {
                        document.getElementById('loadAvg').innerText = `${data.load_avg[0]} / ${data.load_avg[1]} / ${data.load_avg[2]}`;
                    }
                    
                    if (document.getElementById('coreUsageContainer') && data.cores) {
                        let coreHtml = '';
                        data.cores.forEach(c => {
                            coreHtml += `<span>${c.core}: <b class="${c.usage > 80 ? 'text-neon-red' : 'text-white'}">${c.usage}%</b></span>`;
                        });
                        document.getElementById('coreUsageContainer').innerHTML = coreHtml;
                    }

                    // RAM - Dùng data.ram.percent để sửa lỗi [object Object]
                    if (data.ram) {
                        ramChart.data.datasets[0].data = [data.ram.percent, 100 - data.ram.percent];
                        ramChart.data.datasets[0].backgroundColor[0] = data.ram.percent > 80 ? '#ff003c' : '#ffb000';
                        ramChart.update();
                        document.getElementById('ramText').innerText = data.ram.percent + '%';
                        document.getElementById('ramUsed').innerText = data.ram.used + ' MB';
                        document.getElementById('ramTotal').innerText = data.ram.total + ' MB';
                        document.getElementById('ramAvail').innerText = data.ram.available + ' MB';
                    }

              // DISK 
                    if (data.disk) {
                        diskChart.data.datasets[0].data = [data.disk.percent, 100 - data.disk.percent];
                        diskChart.update();
                        document.getElementById('diskText').innerText = data.disk.percent + '%';
                        // Đã ép làm tròn 2 chữ số thập phân
                        document.getElementById('diskUsed').innerText = parseFloat(data.disk.used).toFixed(2) + ' GB';
                        document.getElementById('diskTotal').innerText = data.disk.total + ' GB';
                    }
                    
                    // Network Speed
                    let now = Date.now();
                    let timeDiff = (now - lastTime) / 1000;
                    let rxSpeed = 0, txSpeed = 0;
                    
                    if (prevRx !== 0 && timeDiff > 0 && data.network) {
                        rxSpeed = ((data.network.rx - prevRx) / 1024 / timeDiff).toFixed(1);
                        txSpeed = ((data.network.tx - prevTx) / 1024 / timeDiff).toFixed(1);
                        if (rxSpeed < 0) rxSpeed = 0;
                        if (txSpeed < 0) txSpeed = 0;
                    }
                    
                    if(data.network) {
                        prevRx = data.network.rx; prevTx = data.network.tx;
                    }
                    lastTime = now;
                    
                    document.getElementById('rxSpeed').innerText = rxSpeed;
                    document.getElementById('txSpeed').innerText = txSpeed;

                    netChart.data.datasets[0].data.shift();
                    netChart.data.datasets[0].data.push(rxSpeed);
                    netChart.data.datasets[1].data.shift();
                    netChart.data.datasets[1].data.push(txSpeed);
                    netChart.update();

                    // Terminal Logs
                    if (document.getElementById('terminalLogs') && data.logs) {
                        let logHtml = '';
                        data.logs.forEach(log => {
                            let colorClass = log.includes('error') || log.includes('Exception') ? 'text-neon-red' : 'text-neon-green';
                            logHtml += `<div class="${colorClass} mb-1.5">> ${log}</div>`;
                        });
                        document.getElementById('terminalLogs').innerHTML = logHtml;
                        const logBox = document.getElementById('terminalLogs');
                        logBox.scrollTop = logBox.scrollHeight;
                    }

                    // Processes
                    if (document.getElementById('processTable') && data.processes) {
                        let processHtml = '';
                        data.processes.forEach(p => {
                            processHtml += `<tr class="hover:bg-neon-blue/10 transition-colors"><td class="py-2.5 text-white/70">${p.pid}</td><td class="py-2.5">${p.user}</td><td class="py-2.5 text-white font-bold tracking-wider">${p.cmd}</td><td class="py-2.5 text-neon-red text-right pr-2">${p.cpu}</td><td class="py-2.5 text-neon-green text-right">${p.mem}</td></tr>`;
                        });
                        document.getElementById('processTable').innerHTML = processHtml;
                    }
                })
                .catch(err => console.error("Telemetry Link Severed.", err));
        }

        fetchInfraData();
        setInterval(fetchInfraData, 2000);
    </script>
</body>
</html>