<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — CafeRekomendasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-coffee-800 via-coffee-700 to-coffee-600 flex items-center justify-center p-4 font-sans">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="text-4xl">☕</span>
            <h1 class="text-2xl font-bold text-white mt-2">CafeRekomendasi</h1>
            <p class="text-coffee-300 text-sm">Admin Panel</p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <h2 class="text-xl font-bold text-coffee-800 mb-6 text-center">Login Admin</h2>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-4">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-4">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-coffee-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-coffee-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none transition-all text-sm" id="email-input"
                           placeholder="admin@caferekomendasi.com">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-coffee-700 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 rounded-xl border border-coffee-200 focus:border-coffee-500 focus:ring-2 focus:ring-coffee-200 outline-none transition-all text-sm" id="password-input"
                           placeholder="••••••••">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-coffee-300 text-coffee-600 focus:ring-coffee-500">
                    <label for="remember" class="text-sm text-coffee-500 ml-2">Ingat saya</label>
                </div>
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-coffee-700 to-coffee-600 text-white font-bold rounded-xl hover:from-coffee-600 hover:to-coffee-500 transition-all shadow-lg" id="login-btn">
                    Masuk
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-sm text-coffee-400 hover:text-coffee-600">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
