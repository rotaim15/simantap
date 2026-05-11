<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Disposisi Surat') — SIMANTAP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    @yield('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="h-full bg-slate-50 font-sans antialiased" x-data>

    {{-- Toast Notification --}}
    <div x-data="toast()" x-on:notify.window="notify($event.detail.message, $event.detail.type)"
        class="fixed top-5 right-5 z-[9999] space-y-2 no-print">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" :class="{
            'bg-emerald-600': type === 'success',
            'bg-red-600': type === 'error',
            'bg-amber-500': type === 'warning',
            'bg-blue-600': type === 'info'
         }" class="flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg text-white min-w-72 max-w-sm">
            <div class="shrink-0">
                <template x-if="type === 'success'">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
                <template x-if="type === 'error'">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </template>
                <template x-if="type === 'warning' || type === 'info'">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
            </div>
            <span x-text="message" class="text-sm font-medium flex-1"></span>
            <button @click="show = false" class="shrink-0 opacity-70 hover:opacity-100">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div class="flex h-full" x-data="sidebar()">
        {{-- Sidebar --}}
        <aside :class="open ? 'w-64' : 'w-[72px]'"
            class="fixed left-0 top-0 h-full bg-gradient-to-b from-[#0c1a3a] to-[#0e2154] z-50 transition-all duration-300 ease-in-out shadow-xl overflow-hidden no-print">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-4 py-5 border-b border-white/10">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shrink-0 shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div x-show="open" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" class="overflow-hidden">
                    <p class="text-white font-display font-bold text-base leading-tight">SIMANTAP</p>
                    <p class="text-white/50 text-[10px] font-medium tracking-widest uppercase">Sistem Disposisi</p>
                </div>
            </div>

            {{-- Toggle --}}
            <button @click="toggle()"
                class="absolute -right-3.5 top-[72px] w-7 h-7 bg-white rounded-full shadow-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:text-primary-600 transition-colors no-print">
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- Navigation --}}
            <nav class="p-3 mt-2 space-y-0.5 overflow-y-auto max-h-[calc(100vh-180px)]">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all group {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Dashboard</span>
                </a>

                {{-- Section Label --}}
                <div x-show="open" class="pt-4 pb-1 px-3">
                    <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest">Surat</p>
                </div>

                <a href="{{ route('surat-masuk.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Surat Masuk</span>
                </a>

                <a href="{{ route('surat-keluar.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Surat Keluar</span>
                </a>

                {{-- Section Label --}}
                <div x-show="open" class="pt-4 pb-1 px-3">
                    <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest">Disposisi</p>
                </div>

                <a href="{{ route('disposisi.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('disposisi.index') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Semua Disposisi</span>
                </a>

                <a href="{{ route('disposisi.inbox') }}"
                    class="sidebar-link flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('disposisi.inbox') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414A1 1 0 0117.414 13H20" />
                        </svg>
                        <span x-show="open" class="text-sm font-medium whitespace-nowrap">Kotak Masuk</span>
                    </div>
                    @php $pendingCount = auth()->user()->disposisiPendingCount(); @endphp
                    @if($pendingCount > 0)
                    <span x-show="open"
                        class="bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">{{
                        $pendingCount }}</span>
                    @endif
                </a>

                @if(auth()->user()->isAdmin())
                {{-- Section Label --}}
                <div x-show="open" class="pt-4 pb-1 px-3">
                    <p class="text-white/30 text-[10px] font-bold uppercase tracking-widest">Administrasi</p>
                </div>

                <a href="{{ url('users.index') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="open" class="text-sm font-medium whitespace-nowrap">Pengguna</span>
                </a>
                @endif
            </nav>

            {{-- User info at bottom --}}
            <div class="absolute bottom-0 left-0 right-0 p-3 border-t border-white/10">
                <a href="{{ url('profil') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 transition-all group">
                    <img src="{{ auth()->user()->getAvatarUrl() }}"
                        class="w-9 h-9 rounded-xl object-cover ring-2 ring-white/20 shrink-0"
                        alt="{{ auth()->user()->name }}">
                    <div x-show="open" class="overflow-hidden flex-1">
                        <p class="text-white text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                        <p class="text-white/50 text-xs truncate capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}" x-show="open">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 mt-1 rounded-xl text-white/50 hover:text-white hover:bg-white/10 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main :class="open ? 'ml-64' : 'ml-[72px]'"
            class="flex-1 flex flex-col min-h-full transition-all duration-300 ease-in-out">

            {{-- Top Bar --}}
            <header
                class="bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between sticky top-0 z-40 no-print">
                <div>
                    <h1 class="text-lg font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                    <nav class="text-xs text-slate-400 mt-0.5">
                        @yield('breadcrumb')
                    </nav>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Notifications --}}
                    @php $pendingCount = auth()->user()->disposisiPendingCount(); @endphp
                    <a href="{{ route('disposisi.inbox') }}"
                        class="relative w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 hover:text-slate-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if($pendingCount > 0)
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{
                            $pendingCount }}</span>
                        @endif
                    </a>
                    <div class="flex items-center gap-2">
                        <img src="{{ auth()->user()->getAvatarUrl() }}" class="w-9 h-9 rounded-xl object-cover" alt="">
                        <div class="hidden sm:block">
                            <p class="text-sm font-semibold text-slate-700 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->jabatan ??
                                auth()->user()->role }}</p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="px-6 pt-4 no-print">
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                    class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm animate-fade-in-up">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                    <button @click="show = false" class="ml-auto text-emerald-600 hover:text-emerald-800">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @endif
                @if(session('error'))
                <div x-data="{ show: true }" x-show="show"
                    class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm animate-fade-in-up">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                    <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @endif
            </div>

            {{-- Page Content --}}
            <div class="flex-1 p-6">
                @yield('content')
            </div>

            {{-- Footer --}}
            <footer class="px-6 py-4 text-center text-xs text-slate-400 border-t border-slate-100 no-print">
                © {{ date('Y') }} SIMANTAP — Sistem Manajemen Tata Naskah & Disposisi
            </footer>
        </main>
    </div>

    @stack('scripts')
</body>

</html>