<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgendaRapat - Create Agenda</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />


    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-surface text-on-surface antialiased overflow-x-hidden" x-data="{ isSidebarOpen: false }"
    x-data="navigationHandler()">
    <!-- SideNavBar -->
    <x-dashboard.side />
    <!-- Main Content Area -->
    <main class="lg:pl-64 min-h-screen transition-all duration-300 w-full">
        <!-- TopAppBar -->
        <x-dashboard.header />
        <!-- Form Content -->
        <div class="p-8 max-w-6xl mx-auto">
            <div x-show="isLoading" class="fixed top-0 left-0 w-full h-1 bg-blue-500 animate-pulse z-50">

                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600"></div>
            </div>

            <div id="content-area" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                {{-- content --}}
                @yield('content')
            </div>
        </div>
    </main>


    @stack('scripts')
</body>

</html>