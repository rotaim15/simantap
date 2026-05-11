{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIMANTAP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased">

    <div class="min-h-screen flex">
        {{-- Left decorative panel --}}
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#0c1a3a] via-[#0e2154] to-[#1a3a7a] relative overflow-hidden flex-col items-center justify-center p-12">
            {{-- Background pattern --}}
            <div class="absolute inset-0 opacity-5">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#grid)" />
                </svg>
            </div>

            {{-- Decorative circles --}}
            <div class="absolute top-20 right-20 w-64 h-64 rounded-full bg-primary-500/10 blur-3xl"></div>
            <div class="absolute bottom-20 left-10 w-48 h-48 rounded-full bg-navy-500/20 blur-2xl"></div>

            <div class="relative z-10 max-w-md text-center">
                <div
                    class="w-20 h-20 rounded-3xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-primary-500/30">
                    <svg class="w-11 h-11 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>

                <h1 class="font-display text-4xl font-bold text-white mb-3">SIMANTAP</h1>
                <p class="text-primary-300 text-sm font-semibold tracking-[0.2em] uppercase mb-6">Sistem Manajemen Tata
                    Naskah & Disposisi</p>
                <p class="text-white/60 text-base leading-relaxed">
                    Platform digital untuk pengelolaan surat masuk, surat keluar, dan proses disposisi secara efisien
                    dan terorganisir.
                </p>

                <div class="mt-12 grid grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">∞</div>
                        <div class="text-white/40 text-xs mt-1">Dokumen</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">24/7</div>
                        <div class="text-white/40 text-xs mt-1">Akses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">100%</div>
                        <div class="text-white/40 text-xs mt-1">Digital</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right login form --}}
        <div class="flex-1 flex items-center justify-center p-8 bg-slate-50">
            <div class="w-full max-w-md">
                <div class="lg:hidden text-center mb-8">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h1 class="font-display text-2xl font-bold text-slate-800">SIMANTAP</h1>
                </div>

                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-8 border border-slate-100">
                    <h2 class="text-2xl font-bold text-slate-800 mb-1">Selamat Datang</h2>
                    <p class="text-slate-500 text-sm mb-8">Masuk ke akun Anda untuk melanjutkan</p>

                    <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }"
                        @submit="loading = true">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white form-input transition-all @error('email') border-red-400 @enderror"
                                        placeholder="nama@instansi.go.id" required autofocus>
                                </div>
                                @error('email')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
                                <div class="relative" x-data="{ show: false }">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input :type="show ? 'text' : 'password'" name="password"
                                        class="w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white form-input transition-all @error('password') border-red-400 @enderror"
                                        placeholder="••••••••" required>
                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="show" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="remember"
                                        class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm text-slate-600">Ingat saya</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" :disabled="loading"
                            class="w-full mt-6 bg-gradient-to-r from-primary-600 to-navy-700 hover:from-primary-700 hover:to-navy-800 text-white py-3 px-6 rounded-xl font-semibold text-sm transition-all shadow-lg shadow-primary-500/30 hover:shadow-primary-500/50 disabled:opacity-70 flex items-center justify-center gap-2">
                            <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span x-text="loading ? 'Memproses...' : 'Masuk ke Sistem'"></span>
                        </button>
                    </form>
                </div>

                <p class="text-center text-xs text-slate-400 mt-6">© {{ date('Y') }} SIMANTAP. Hak cipta dilindungi
                    undang-undang.</p>
            </div>
        </div>
    </div>

</body>

</html>