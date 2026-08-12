<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — CafeRekomendasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-coffee-900 via-coffee-800 to-coffee-700 flex items-center justify-center p-4 font-sans relative overflow-hidden">
    {{-- Decorative background elements --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-coffee-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-96 h-96 bg-coffee-400 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-coffee-600 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
    </div>

    <div class="w-full max-w-md z-10">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 mb-4 shadow-xl">
                <svg class="w-8 h-8 text-coffee-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12h19.5" />
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">CafeRekomendasi</h1>
            <p class="text-coffee-300 font-medium mt-2">Secure Admin Portal</p>
        </div>

        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-2xl border border-coffee-100">
            <div class="flex items-center justify-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-coffee-50 flex items-center justify-center text-coffee-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-coffee-900">Admin Login</h2>
            </div>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-coffee-800 mb-2">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-coffee-400 group-focus-within:text-coffee-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-coffee-200 focus:border-coffee-500 focus:ring-4 focus:ring-coffee-500/10 outline-none transition-all text-coffee-900 font-medium placeholder:text-coffee-300 placeholder:font-normal bg-coffee-50/50 focus:bg-white" id="email-input"
                               placeholder="admin@caferekomendasi.com">
                    </div>
                    @error('email')<p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-coffee-800 mb-2">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-coffee-400 group-focus-within:text-coffee-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                        </div>
                        <input type="password" name="password" required
                               class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-coffee-200 focus:border-coffee-500 focus:ring-4 focus:ring-coffee-500/10 outline-none transition-all text-coffee-900 font-medium placeholder:text-coffee-300 placeholder:font-normal bg-coffee-50/50 focus:bg-white" id="password-input"
                               placeholder="••••••••">
                    </div>
                    @error('password')<p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center pt-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-coffee-300 text-coffee-700 focus:ring-coffee-500 transition-colors cursor-pointer">
                    <label for="remember" class="text-sm font-medium text-coffee-600 ml-2.5 cursor-pointer select-none">Ingat saya pada perangkat ini</label>
                </div>
                
                <button type="submit" class="w-full mt-2 py-4 bg-gradient-to-r from-coffee-800 to-coffee-600 text-white font-bold rounded-xl hover:from-coffee-700 hover:to-coffee-500 transition-all duration-300 shadow-xl shadow-coffee-700/30 hover:shadow-coffee-600/40 hover:-translate-y-0.5 flex justify-center items-center gap-2" id="login-btn">
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </form>

            <div class="text-center mt-8 pt-6 border-t border-coffee-100">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-coffee-500 hover:text-coffee-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
</body>
</html>
