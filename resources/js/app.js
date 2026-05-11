import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import intersect from '@alpinejs/intersect';

Alpine.plugin(persist);
Alpine.plugin(intersect);

// Global Alpine data
Alpine.data('sidebar', () => ({
    open: Alpine.$persist(true).as('sidebar_open'),
    toggle() {
        this.open = !this.open;
    }
}));

Alpine.data('toast', () => ({
    show: false,
    message: '',
    type: 'success',
    notify(message, type = 'success') {
        this.message = message;
        this.type = type;
        this.show = true;
        setTimeout(() => this.show = false, 3500);
    }
}));

Alpine.data('modal', () => ({
    open: false,
    show() { this.open = true; },
    hide() { this.open = false; },
}));

Alpine.data('datatable', () => ({
    search: '',
    perPage: 10,
    currentPage: 1,
    sortBy: '',
    sortDir: 'asc',
    selected: [],
    toggleSort(col) {
        if (this.sortBy === col) {
            this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortBy = col;
            this.sortDir = 'asc';
        }
    }
}));

Alpine.data('disposisiForm', () => ({
    tujuan: [],
    addTujuan(user) {
        if (!this.tujuan.find(t => t.id === user.id)) {
            this.tujuan.push(user);
        }
    },
    removeTujuan(id) {
        this.tujuan = this.tujuan.filter(t => t.id !== id);
    }
}));

Alpine.start();
window.Alpine = Alpine;
