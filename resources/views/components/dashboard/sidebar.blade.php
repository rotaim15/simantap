<div x-data="{ isSidebarOpen: false }">

    <!-- Mobile Button -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button @click="isSidebarOpen = true" class="p-2 bg-white shadow rounded">
            ☰
        </button>
    </div>

    <!-- Overlay -->
    <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed left-0 top-0 h-full w-64 bg-white p-4 transition-transform lg:translate-x-0 z-50">

        <h2 class="font-bold text-xl mb-6">AgendaRapat</h2>

        <nav class="space-y-2">

            <a href="/peserta" :class="currentPath === '/peserta' ? 'bg-blue-100' : ''" class="block p-2 rounded">
                Peserta
            </a>

            <a href="/lokasi" :class="currentPath === '/lokasi' ? 'bg-blue-100' : ''" class="block p-2 rounded">
                Lokasi
            </a>

            <a href="/agenda" :class="currentPath === '/agenda' ? 'bg-blue-100' : ''" class="block p-2 rounded">
                Agenda
            </a>

        </nav>
    </aside>
</div>