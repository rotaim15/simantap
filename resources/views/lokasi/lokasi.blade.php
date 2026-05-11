<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Daftar Lokasi | Meeting Architect</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-low": "#f3f4f5",
                        "primary-container": "#0070ea",
                        "tertiary": "#006b24",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary": "#ffffff",
                        "inverse-on-surface": "#f0f1f2",
                        "on-tertiary-fixed-variant": "#00531a",
                        "surface-container": "#edeeef",
                        "on-background": "#191c1d",
                        "background": "#f8f9fa",
                        "surface-bright": "#f8f9fa",
                        "error": "#ba1a1a",
                        "on-tertiary-fixed": "#002106",
                        "outline-variant": "#c1c6d7",
                        "on-tertiary-container": "#f7fff2",
                        "tertiary-fixed": "#83fc8e",
                        "primary-fixed": "#d8e2ff",
                        "surface-container-high": "#e7e8e9",
                        "inverse-primary": "#adc7ff",
                        "surface-dim": "#d9dadb",
                        "tertiary-fixed-dim": "#66df75",
                        "outline": "#717786",
                        "on-error-container": "#93000a",
                        "on-primary": "#ffffff",
                        "on-surface-variant": "#414754",
                        "on-primary-fixed-variant": "#004493",
                        "surface-variant": "#e1e3e4",
                        "on-secondary-fixed-variant": "#26467c",
                        "tertiary-container": "#008730",
                        "surface": "#f8f9fa",
                        "error-container": "#ffdad6",
                        "inverse-surface": "#2e3132",
                        "on-primary-container": "#fefcff",
                        "primary": "#0059bb",
                        "on-secondary-fixed": "#001a41",
                        "on-error": "#ffffff",
                        "secondary-fixed-dim": "#adc7ff",
                        "secondary-container": "#a4c1ff",
                        "on-primary-fixed": "#001a41",
                        "secondary-fixed": "#d8e2ff",
                        "primary-fixed-dim": "#adc7ff",
                        "on-secondary-container": "#2f4e85",
                        "surface-container-highest": "#e1e3e4",
                        "surface-tint": "#005bc0",
                        "secondary": "#405e96",
                        "on-tertiary": "#ffffff",
                        "on-surface": "#191c1d"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .editorial-shadow {
            box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.04);
        }

        .glass-header {
            background: rgba(248, 249, 250, 0.8);
            backdrop-filter: blur(24px);
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface">
    <!-- SideNavBar (Authority Source: JSON) -->
    <aside
        class="h-screen w-64 fixed left-0 top-0 bg-slate-100 dark:bg-slate-900 flex flex-col h-full p-4 space-y-2 z-50">
        <div class="mb-8 px-2">
            <h1 class="text-lg font-black text-slate-900 dark:text-slate-50">Architect Admin</h1>
            <p class="text-xs text-slate-500 font-medium tracking-wider">Enterprise Suite</p>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-all duration-200 ease-in-out"
                href="#">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-all duration-200 ease-in-out"
                href="#">
                <span class="material-symbols-outlined" data-icon="calendar_today">calendar_today</span>
                <span class="font-medium text-sm">Meetings</span>
            </a>
            <!-- Active State: Locations -->
            <a class="flex items-center gap-3 px-3 py-2 text-blue-700 dark:text-blue-400 bg-white dark:bg-slate-950 rounded-lg shadow-sm transition-all duration-200 ease-in-out"
                href="#">
                <span class="material-symbols-outlined" data-icon="location_on"
                    style="font-variation-settings: 'FILL' 1;">location_on</span>
                <span class="font-medium text-sm">Locations</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-all duration-200 ease-in-out"
                href="#">
                <span class="material-symbols-outlined" data-icon="group">group</span>
                <span class="font-medium text-sm">Participants</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-all duration-200 ease-in-out"
                href="#">
                <span class="material-symbols-outlined" data-icon="leaderboard">leaderboard</span>
                <span class="font-medium text-sm">Analytics</span>
            </a>
        </nav>
        <div class="pt-4 border-t border-slate-200 dark:border-slate-800 space-y-1">
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-all duration-200 ease-in-out"
                href="#">
                <span class="material-symbols-outlined" data-icon="help">help</span>
                <span class="font-medium text-sm">Support</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-all duration-200 ease-in-out"
                href="#">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                <span class="font-medium text-sm">Sign Out</span>
            </a>
        </div>
    </aside>
    <!-- Main Content Canvas -->
    <main class="ml-64 min-h-screen">
        <!-- TopNavBar (Authority Source: JSON) -->
        <header
            class="fixed top-0 right-0 left-64 h-16 glass-header z-40 flex justify-between items-center px-8 tonal-shift bg-slate-100 dark:bg-slate-900">
            <div class="flex items-center flex-1 max-w-xl">
                <div class="relative w-full">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg"
                        data-icon="search">search</span>
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm transition-all outline-none focus:bg-surface-container-lowest"
                        placeholder="Search meeting rooms, capacity, or equipment..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="p-2 text-slate-500 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors rounded-full">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                </button>
                <button
                    class="p-2 text-slate-500 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-colors rounded-full">
                    <span class="material-symbols-outlined" data-icon="settings">settings</span>
                </button>
                <div class="h-8 w-8 rounded-full overflow-hidden ml-2 ring-2 ring-white shadow-sm">
                    <img alt="User profile"
                        data-alt="close-up portrait of a professional male architect in a bright office setting with soft natural light"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBY3M9EsGx1GepoOXZId2Yd0VBOtFYycM7r0xaPqlph7JKHFYIZVct-lhObgRTgYuN6XvV51nX0OhQd1qdrx3UcyUoaV_MbQ9P4RmrAiV8jkl83lH9u0TBDc1dv_f4v8HzLL35zrLD501sntGEg1ZMA6EMOoVD0CctDgNZ-tjzxPKQ9kkWd7qbe03KUVeEbn6Zuc03hUyEEPFQYY-3bgzEU8xfx2Ioz4xwny5c44L2pSO4hQ876v6QOVUeyXTHUnnwGmbqTxfzuBvyC" />
                </div>
            </div>
        </header>
        <!-- Content Area -->
        <div class="pt-24 px-10 pb-12">
            <!-- Hero Header Section (Editorial Authority) -->
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-[2.75rem] font-black tracking-tight leading-none text-on-surface mb-2">Daftar Lokasi
                    </h2>
                    <p class="text-on-surface-variant max-w-md">Manage your collaborative environments across the
                        enterprise campus with real-time availability status.</p>
                </div>
                <button
                    class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-container text-on-primary rounded-xl font-semibold shadow-lg hover:shadow-primary/20 transition-all scale-100 active:scale-95">
                    <span class="material-symbols-outlined" data-icon="add">add</span>
                    <span>Add New Location</span>
                </button>
            </div>
            <!-- Bento Grid of Meeting Rooms -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Room Card 1 -->
                <div
                    class="group bg-surface-container-lowest rounded-xl overflow-hidden editorial-shadow transition-all hover:translate-y-[-4px]">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            data-alt="spacious modern conference room with large glass windows overlooking a city skyline at sunset with sleek wooden furniture"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCCrvHCkeGinrXi7gw0zTBJ4XtH9SG2FSUljU3D861NjEcUkS-caoK1lDbldFi8QlEg-EMbleHNAPlH8jprDarz87ulgiCmnTsi8zW7GraABoyNCs0TalrqkzaYrzZ1X6gOCFjxCUA1rUOa5GvFar1kEO5WMFIOJI3RqzO99ygMdqoTFpkRRSRcGNyxOtUCSIrhVHkd8aTkRdaduRz0l_cms3iQFIA-1_C0HZas8jlgoH_p3iTLMiaH3V8CHXlnFwq79cigoG1DVL2b" />
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-tertiary-container text-on-tertiary-container text-[10px] font-bold uppercase tracking-widest rounded-full">Available</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-on-surface leading-tight">Executive Suite A</h3>
                                <div class="flex items-center gap-1 text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                                    <span class="text-xs font-medium">Capacity: 12 People</span>
                                </div>
                            </div>
                            <button class="p-2 text-on-surface-variant hover:bg-surface-container rounded-full">
                                <span class="material-symbols-outlined" data-icon="more_vert">more_vert</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant/15">
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="tv">tv</span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="wifi">wifi</span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="videocam">videocam</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Room Card 2 -->
                <div
                    class="group bg-surface-container-lowest rounded-xl overflow-hidden editorial-shadow transition-all hover:translate-y-[-4px]">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            data-alt="minimalist Scandinavian style office meeting pod with warm ambient lighting and soft textile acoustic panels"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZ6a4CGH_Y8wUBJ2tQhIY6wl9yE4N0j-arkkDP3o6UIJEPjQ29j4R5Z7sc2Eo5q9IkOXLGkez-3DSN1MxDu_EPaMzo2HDwFxxZnnd7KTXyJtYZmgsF2v75TaDBlXHo4NkvbLIx46wsTSKVT50ys4NhFfD_emhjaQknmfM2QEObWvtmF6tRueLyl2iydpEnb1xckR5EkIizsNgBucKPSTXnnDbPFybK4F_g_XeuVrqlNW41-8gs60P8CJuqosR9uUVMMUolqtIzBNYx" />
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-error-container text-on-error-container text-[10px] font-bold uppercase tracking-widest rounded-full">In
                                Use</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-on-surface leading-tight">Focus Pod 04</h3>
                                <div class="flex items-center gap-1 text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                                    <span class="text-xs font-medium">Capacity: 4 People</span>
                                </div>
                            </div>
                            <button class="p-2 text-on-surface-variant hover:bg-surface-container rounded-full">
                                <span class="material-symbols-outlined" data-icon="more_vert">more_vert</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant/15">
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="wifi">wifi</span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="cast">cast</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Room Card 3 -->
                <div
                    class="group bg-surface-container-lowest rounded-xl overflow-hidden editorial-shadow transition-all hover:translate-y-[-4px]">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            data-alt="ultra-modern creative studio workspace with high industrial ceilings and large digital whiteboards on the walls"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB__EZOfNrWT7Tl3sWEpZA8Hfm7wTtH7LI1j09_O7N69un0orG1ofJNEYwWcTIFZO9Fkv4YExyk_6WgsYtrIrg66EFgiwAN4kGTdo7_I7-kXb_FtxrfWblJ6LOqdgoDf57yvbUpD1me4GaLDMSrxPihPgugdUt7HH3asO-e1ghEZEV_1xcv93deXkGkrPKHx1B3JWJWO7ifh1vjsqZfnpL1JJCGNXko7UFQ4YIn3X0d6RaE8Nn55F7aWBYMUXm46laKhnDD2R7LEyPE" />
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-tertiary-container text-on-tertiary-container text-[10px] font-bold uppercase tracking-widest rounded-full">Available</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-on-surface leading-tight">Creative Workshop</h3>
                                <div class="flex items-center gap-1 text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                                    <span class="text-xs font-medium">Capacity: 20 People</span>
                                </div>
                            </div>
                            <button class="p-2 text-on-surface-variant hover:bg-surface-container rounded-full">
                                <span class="material-symbols-outlined" data-icon="more_vert">more_vert</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant/15">
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="tv">tv</span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="wifi">wifi</span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="co_present">co_present</span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="mic">mic</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Room Card 4 -->
                <div
                    class="group bg-surface-container-lowest rounded-xl overflow-hidden editorial-shadow transition-all hover:translate-y-[-4px]">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            data-alt="sleek professional boardroom with ergonomic chairs and a long dark wood table with integrated power outlets"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCuXPqfRtz6hZFL9i_MoNG_spsSdDAPjbCAxQnQT3elgjqxeQvL0PEaB-pvg39iMjbYaVIrXPAe6f2MekP3fLuNxDPXgKC28wLuZ2AlrOQwKdA4gDahhbM_4G1eONbbmxuI2p8WgPBW1xH-1Sbnx2RXtoyasFbB2aLMxYLVP9G8wWFvv1IOdQcw4QccRZP6N5Gfktk9af9P03UHq293yaEuXk5h9g8R92Zoa3-2iCMoLeEbU3SMTVnqgxwvTOlJQR7UIutbadMI6GfZ" />
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-tertiary-container text-on-tertiary-container text-[10px] font-bold uppercase tracking-widest rounded-full">Available</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-on-surface leading-tight">Boardroom Central</h3>
                                <div class="flex items-center gap-1 text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                                    <span class="text-xs font-medium">Capacity: 16 People</span>
                                </div>
                            </div>
                            <button class="p-2 text-on-surface-variant hover:bg-surface-container rounded-full">
                                <span class="material-symbols-outlined" data-icon="more_vert">more_vert</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant/15">
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="tv">tv</span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="wifi">wifi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Room Card 5 -->
                <div
                    class="group bg-surface-container-lowest rounded-xl overflow-hidden editorial-shadow transition-all hover:translate-y-[-4px]">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            data-alt="bright open-plan collaboration zone with colorful lounge seating and mobile whiteboards in a bright airy office"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzYv2NlKwK5FVRpttbtkQGLuqevjAUTvJy6KSGvpAsSZopN5ntzjJB7Plcu_Xd8ICoZcLGQUTItBms9ccYhTi4qkuLP9pA4w3ZNSwS1D8zNRFInNYU5xMaa76Tbk00zgMWhZP45-ejIHXQyvFgEJ2g0NIGg_-yxT9FxZ9213AVmhpO8KFkLL-_QO9_dRTfmi_GFh16YvBKbrFXpOdud5JqNOm1Y0m4mJHWegJuJCJPnFFb8HZCYuB2fJdrzgEg3mW4k9r758BaTbWC" />
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-error-container text-on-error-container text-[10px] font-bold uppercase tracking-widest rounded-full">In
                                Use</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-on-surface leading-tight">Agile Zone B</h3>
                                <div class="flex items-center gap-1 text-on-surface-variant mt-1">
                                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                                    <span class="text-xs font-medium">Capacity: 8 People</span>
                                </div>
                            </div>
                            <button class="p-2 text-on-surface-variant hover:bg-surface-container rounded-full">
                                <span class="material-symbols-outlined" data-icon="more_vert">more_vert</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 pt-4 border-t border-outline-variant/15">
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="wifi">wifi</span>
                            </div>
                            <div
                                class="flex items-center gap-1.5 px-2.5 py-1.5 bg-surface-container-low rounded-lg text-on-surface-variant">
                                <span class="material-symbols-outlined text-lg" data-icon="draw">draw</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Empty State / Add New Placeholder -->
                <div
                    class="group border-2 border-dashed border-outline-variant/30 rounded-xl flex flex-col items-center justify-center p-12 text-center hover:border-primary/50 transition-colors cursor-pointer">
                    <div
                        class="h-16 w-16 bg-surface-container rounded-full flex items-center justify-center mb-4 group-hover:bg-primary-fixed transition-colors">
                        <span
                            class="material-symbols-outlined text-3xl text-on-surface-variant group-hover:text-primary"
                            data-icon="add_location_alt">add_location_alt</span>
                    </div>
                    <h3 class="font-bold text-on-surface">Expand Campus</h3>
                    <p class="text-xs text-on-surface-variant mt-2 max-w-[150px]">Add a new meeting space or
                        collaboration area.</p>
                </div>
            </div>
            <!-- Asymmetric Utility Section -->
            <div class="mt-20 flex gap-8">
                <div class="flex-1 bg-surface-container-low rounded-xl p-8 flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-bold text-on-surface mb-2">Location Insights</h4>
                        <p class="text-sm text-on-surface-variant">Your meeting rooms were utilized at 84% capacity this
                            week.</p>
                    </div>
                    <div class="flex gap-2">
                        <div class="h-12 w-2 bg-primary rounded-full"></div>
                        <div class="h-12 w-2 bg-primary rounded-full opacity-60"></div>
                        <div class="h-12 w-2 bg-primary rounded-full opacity-40"></div>
                        <div class="h-12 w-2 bg-primary rounded-full opacity-20"></div>
                    </div>
                </div>
                <div class="w-1/3 bg-inverse-surface text-inverse-on-surface rounded-xl p-8 relative overflow-hidden">
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-9xl opacity-10"
                        data-icon="info">info</span>
                    <h4 class="text-lg font-bold mb-2">Policy Update</h4>
                    <p class="text-xs opacity-70 leading-relaxed">Starting next Monday, all boardrooms must be booked at
                        least 24 hours in advance through the Architect Portal.</p>
                    <a class="inline-flex items-center gap-1 text-primary-fixed mt-4 text-xs font-bold uppercase tracking-wider"
                        href="#">
                        Read more <span class="material-symbols-outlined text-sm"
                            data-icon="arrow_forward">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>