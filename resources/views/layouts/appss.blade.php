<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AgendaRapat</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="//unpkg.com/alpinejs" defer></script>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50" x-data="navigationHandler()">

    <!-- Sidebar -->
    @include('components.dashboard.sidebar')

    <!-- Main -->
    <main class="lg:pl-64 min-h-screen">

        <div class="p-8 max-w-6xl mx-auto">

            <!-- Loading bar -->
            <div x-show="isLoading" class="fixed top-0 left-0 w-full h-1 bg-blue-500 animate-pulse z-50"></div>

            <!-- Content -->
            <div id="content-area" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                {{ $slot }}

            </div>
        </div>

    </main>

    <!-- NAVIGATION SCRIPT -->
    <script>
        function navigationHandler() {
        return {
            currentPath: window.location.pathname,
            isLoading: false,

            async navigate(url) {
                const path = new URL(url).pathname;
                if (path === this.currentPath) return;

                this.isLoading = true;

                try {
                    const res = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    const html = await res.text();

                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newContent = doc.getElementById('content-area');

                    if (newContent) {
                        document.getElementById('content-area').innerHTML = newContent.innerHTML;
                    }

                    this.currentPath = path;
                    window.history.pushState({}, '', url);

                    this.$nextTick(() => {
                        Alpine.initTree(document.getElementById('content-area'));
                    });

                } catch (e) {
                    console.error(e);
                } finally {
                    this.isLoading = false;
                }
            }
        }
    }
    </script>

    <!-- INTERCEPT LINK -->
    <script>
        document.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (!link) return;

        if (link.target === '_blank') return;

        if (link.hostname === window.location.hostname) {
            e.preventDefault();

            const app = document.querySelector('[x-data]');
            if (app && app.__x) {
                app.__x.$data.navigate(link.href);
            }
        }
    });
    </script>

    <!-- BACK BUTTON -->
    <script>
        window.addEventListener('popstate', () => {
        const app = document.querySelector('[x-data]');
        if (app && app.__x) {
            app.__x.$data.navigate(window.location.href);
        }
    });
    </script>

    @stack('scripts')
</body>

</html>