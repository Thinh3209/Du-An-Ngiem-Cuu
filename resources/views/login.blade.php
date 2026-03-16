<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Secure Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap');
        body { background-color: #030712; font-family: 'Share Tech Mono', monospace; overflow: hidden; }
        .cyber-grid { background-image: linear-gradient(to right, #1e293b 1px, transparent 1px), linear-gradient(to bottom, #1e293b 1px, transparent 1px); background-size: 40px 40px; opacity: 0.2; }
        .crt::before { content: " "; display: block; position: absolute; top: 0; left: 0; bottom: 0; right: 0; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03)); z-index: 2; background-size: 100% 2px, 3px 100%; pointer-events: none; opacity: 0.2; }
        .glow-border { box-shadow: 0 0 15px rgba(59, 130, 246, 0.5); border: 1px solid #3b82f6; }
    </style>
</head>
<body class="flex items-center justify-center h-screen relative crt">
    <div class="absolute inset-0 cyber-grid pointer-events-none"></div>

    <div class="w-full max-w-md p-8 bg-slate-900/80 backdrop-blur-md glow-border relative z-10">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-white tracking-[0.3em] uppercase mb-2">Q3T<span class="text-blue-500">-SHIELD</span></h1>
            <p class="text-blue-400 text-xs tracking-widest uppercase animate-pulse">Establishing Secure Uplink...</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf <div>
                <label class="block text-blue-400 text-[10px] uppercase tracking-widest mb-2">Admin_Identity (Email)</label>
                <input type="email" name="email" required class="w-full bg-black/50 border border-slate-700 text-white px-4 py-3 outline-none focus:border-blue-500 transition-all font-mono" placeholder="USER_ID@SEC.CORE">
                @error('email') <span class="text-red-500 text-[10px] mt-1 uppercase">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-blue-400 text-[10px] uppercase tracking-widest mb-2">Access_Cipher (Password)</label>
                <input type="password" name="password" required class="w-full bg-black/50 border border-slate-700 text-white px-4 py-3 outline-none focus:border-blue-500 transition-all font-mono" placeholder="********">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-slate-400 text-[10px] uppercase tracking-tighter cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 bg-black border-slate-700 rounded"> Remember_Session
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600/20 border border-blue-500 text-blue-400 hover:bg-blue-600 hover:text-white py-3 font-bold uppercase tracking-[0.2em] transition-all duration-300 shadow-[0_0_10px_rgba(59,130,246,0.3)]">
                Execute_Login
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-800 text-center">
            <span class="text-[8px] text-slate-600 tracking-[0.4em] uppercase">Security Core v1.0.9 // Encrypted Session</span>
        </div>
    </div>
</body>
</html>