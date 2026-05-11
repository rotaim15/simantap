<div class="lg:hidden fixed top-4 left-4 z-[60]">
    <button @click="isSidebarOpen = true" class="p-2 bg-white dark:bg-slate-900 shadow-md rounded-lg text-slate-600">
        <span class="material-symbols-outlined">menu</span>
    </button>
</div>

<div x-show="isSidebarOpen" x-transition:opacity @click="isSidebarOpen = false"
    class="fixed inset-0 bg-black/50 z-[45] lg:hidden">
</div>

<aside :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-950 flex flex-col p-4 space-y-2 z-50 transition-transform duration-300 ease-in-out lg:translate-x-0">

    <div class="mb-8 px-2 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-white">
                <span class="material-symbols-outlined">corporate_fare</span>
            </div>
            <div>
                <h1 class="text-lg font-black text-slate-900 dark:text-slate-50 leading-none">AgendaRapat</h1>
                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Corporate Suite</p>
            </div>
        </div>
        <button @click="isSidebarOpen = false" class="lg:hidden text-slate-500">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <nav class="flex-1 space-y-1">
        <a class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-lg font-sans text-sm font-medium transition-colors"
            href="#">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('peserta.index') }}"
            class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-lg font-sans text-sm font-medium transition-colors">
            <span class="material-symbols-outlined">group</span>
            <span>Peserta</span>
        </a>
        <a href="{{ route('lokasi.index') }}"
            class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-lg font-sans text-sm font-medium transition-colors">
            <span class="material-symbols-outlined">location_on</span>
            <span>Lokasi</span>
        </a>
        <a href="{{ route('agendas.index') }}"
            class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-lg font-sans text-sm font-medium transition-colors">
            <span class="material-symbols-outlined">calendar_month</span>
            <span>Agenda</span>
        </a>

        <!-- 🔽 DROPDOWN MENU -->
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen"
                class="flex items-center justify-between w-full px-3 py-2 text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-lg font-sans text-sm font-medium transition-colors">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">layers</span>
                    <span>Laporan</span>
                </div>
                <span class="material-symbols-outlined transition-transform duration-200"
                    :class="dropdownOpen ? 'rotate-180' : ''">expand_less</span>
            </button>

            <div x-show="dropdownOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"
                @click.away="dropdownOpen = false"
                class="absolute left-0 mt-1 w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg z-20 overflow-hidden">
                <a href="#"
                    class="block px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined text-sm mr-2 align-middle">today</span> Harian
                </a>
                <a href="#"
                    class="block px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined text-sm mr-2 align-middle">calendar_month</span> Bulanan
                </a>
                <a href="#"
                    class="block px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined text-sm mr-2 align-middle">download</span> Export PDF
                </a>
            </div>
        </div>
        <!-- 🔚 END DROPDOWN -->

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 rounded-lg font-sans text-sm font-medium transition-colors">
                <span class="material-symbols-outlined">logout</span>
                <span>Logout</span>
            </a>
        </form>

        <!-- User -->
        <div class="p-4 border-t border-white/10 text-sm mt-auto">
            <div class="flex items-center gap-2">
                @auth
                <div
                    class="bg-green-500 w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs">
                    {{ auth()->user()->name }}
                </div>
                @endauth
                @guest
                <div class="avatar">?</div>
                @endguest
                <div>
                    <div class="font-medium text-slate-900 dark:text-slate-50">{{
                        strtoupper(substr(auth()->user()?->name ?? 'Guest', 0, 1)) }}</div>
                    <div class="text-xs opacity-70">{{ auth()->user()?->role ?? 'Guest' }}</div>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-4">
        <button
            class="w-full bg-gradient-to-r from-primary to-primary-container text-white py-3 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-sm">add</span>
            Create New Meeting
        </button>
    </div>
</aside>
