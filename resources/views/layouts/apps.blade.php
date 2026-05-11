<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900" x-data="spaNavigator()">

    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col">
            <div class="p-6">
                <h1 class="text-xl font-bold text-primary">Meeting App</h1>
            </div>

            <nav class="flex-1 px-4 space-y-2">
                <a href="{{ route('dashboard') }}" @click.prevent="goTo($el.href)"
                    :class="currentUrl === '{{ route('dashboard') }}' ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium">
                    <span class="material-symbols-outlined">dashboard</span> Dashboard
                </a>

                <a href="{{ route('peserta.index') }}" @click.prevent="goTo($el.href)"
                    :class="currentUrl.includes('peserta') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium">
                    <span class="material-symbols-outlined">groups</span> Peserta
                </a>
                <a href="{{ route('lokasi.index') }}" @click.prevent="goTo($el.href)"
                    :class="currentUrl.includes('lokasi') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium">
                    <span class="material-symbols-outlined">location_on</span> Lokasi
                </a>
            </nav>
        </aside>

        <main class="flex-1 flex flex-col relative overflow-hidden">
            <div x-show="isLoading" x-cloak class="absolute top-0 left-0 right-0 h-1 bg-blue-600 animate-pulse z-[100]">
            </div>

            <div class="flex-1 overflow-y-auto" id="slot-content">
                <template x-if="content">
                    <div x-html="content"></div>
                </template>

                {{-- Fallback untuk load pertama kali --}}
                @if(!request()->ajax())
                <div id="initial-content">
                    @yield('content')
                </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        function spaNavigator() {
            return {
                content: '',
                currentUrl: window.location.href,
                isLoading: false,

                init() {
                    // Menangani tombol Back/Forward Browser
                    window.addEventListener('popstate', (e) => {
                        this.loadPage(window.location.href, false);
                    });
                },

                async goTo(url) {
                    if (url === this.currentUrl) return;
                    await this.loadPage(url);
                },

                async loadPage(url, pushState = true) {
                    this.isLoading = true;

                    try {
                        const response = await fetch(url, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const html = await response.text();

                        // Update State
                        this.content = html;
                        this.currentUrl = url;

                        // Sembunyikan konten awal jika ada
                        const initial = document.getElementById('initial-content');
                        if(initial) initial.style.display = 'none';

                        if (pushState) {
                            window.history.pushState({}, '', url);
                        }
                    } catch (error) {
                        console.error("Gagal memuat halaman:", error);
                        window.location.href = url; // Fallback jika gagal
                    } finally {
                        this.isLoading = false;
                    }
                }
            }
        }
    </script>
</body>

</html>