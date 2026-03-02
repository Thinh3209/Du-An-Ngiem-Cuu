<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIELD-AI | Enterprise Portal Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: {
                            850: '#1e293b', // Màu nền tùy chỉnh tối hơn một chút
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Ẩn thanh cuộn nhưng vẫn cho phép cuộn */
        body { -ms-overflow-style: none; scrollbar-width: none; }
        body::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-400 bg-slate-900 selection:bg-indigo-500 selection:text-white">
    <div class="min-h-full flex">
        
        <div class="hidden md:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" 
                 src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80" 
                 alt="Secure Data Center">
            <div class="absolute inset-0 bg-indigo-900 bg-opacity-40 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent"></div>
            
            <div class="absolute bottom-0 left-0 p-12 text-white z-10">
                <h2 class="text-4xl font-bold tracking-tight">Multiple Layers Security</h2>
                <p class="mt-4 text-lg text-indigo-200 max-w-md leading-relaxed">
                    Advanced server protection utilizing AI analysis, honeypots, and proactive defense mechanisms.
                </p>
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-slate-850 border-l border-slate-800">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <h2 class="mt-6 text-3xl font-extrabold text-white tracking-tight">
                        SHIELD-AI Portal
                    </h2>
                    <p class="mt-2 text-sm text-slate-400">
                        Please sign in to access the secure dashboard.
                    </p>
                </div>

                <div class="mt-10">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-950/40 border-l-4 border-red-500 text-red-400 text-sm rounded-r-md">
                            <p class="font-medium">Authentication Failed</p>
                            <p class="mt-1">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <form action="/login" method="POST" class="space-y-7">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-300">
                                Email Address
                            </label>
                            <div class="mt-2 relative rounded-md shadow-sm">
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       autocomplete="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="admin@example.com" 
                                       required 
                                       class="block w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-300">
                                Password
                            </label>
                            <div class="mt-2 relative rounded-md shadow-sm">
                                <input id="password" 
                                       name="password" 
                                       type="password" 
                                       autocomplete="current-password" 
                                       placeholder="••••••••" 
                                       required 
                                       class="block w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" 
                                       name="remember" 
                                       type="checkbox" 
                                       class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-slate-700 bg-slate-900 rounded cursor-pointer">
                                <label for="remember" class="ml-3 block text-sm text-slate-300 select-none cursor-pointer">
                                    Remember this device
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 transition-all duration-200 transform hover:scale-[1.01]">
                                SIGN IN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>