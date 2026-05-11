<header
    class="w-full sticky top-0 z-40 flex justify-between items-center px-8 py-4 bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-xl no-border">
    <div class="flex items-center gap-4">
        <h2 class="text-xl font-bold tracking-tighter text-slate-900 dark:text-slate-50">New Meeting Agenda</h2>
    </div>
    <div class="flex items-center gap-6">
        <form action="{{ route('peserta.index') }}" method="GET">
            <div class="relative group">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                    data-icon="search">search</span>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm w-64 focus:ring-2 focus:ring-primary/20"
                    placeholder="Search resources..."
                    @input.debounce.500ms="if($el.value.length >= 3 || $el.value.length == 0) $el.form.submit()" />


                @if(request('search'))
                <a href="{{ route('peserta.index') }}"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500">
                    <span class="material-symbols-outlined text-sm">close</span>
                </a>
                @endif
            </div>
        </form>
        <div class="flex items-center gap-2">
            <button class="p-2 text-slate-500 hover:bg-slate-200/50 rounded-full transition-colors">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
            </button>
            <button class="p-2 text-slate-500 hover:bg-slate-200/50 rounded-full transition-colors">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
            </button>
            <div class="h-8 w-8 rounded-full bg-slate-300 overflow-hidden ml-2">
                <img alt="User profile" class="w-full h-full object-cover"
                    data-alt="Professional headshot of a corporate executive with clean studio lighting and neutral background"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBqMMPZ6hIxbfCEHBmBrGj0t7wUuUPHbUEQnAQkhvKAPklK8lJ7idK9x7PdjPN90kbBcf1XyQk0ipC6m4qhkZKBfwfoVKtQFgGCZB_f4q-hJRwa99XVd6CvS7awjNtvhizONWTQuOdZoMrA8mkOaaQYpC0L6-WV8EQPn2D-l40dMv01zAtzH0Mp0db4WnNOW7_aqrl6J9mWl8CXuYL6e-vvPj940Pm8hab7Wv_Z6xye1tsqlEolwrggGry4HXM7h4EZ2x7hRsetsEkU" />
            </div>
        </div>
    </div>
</header>