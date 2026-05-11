@extends('layouts.dashboard')
@section('content')
<!-- Main@ Content Area -->
{{-- <div class="p-8 space-y-8 flex-1">
    <!-- Page Title & Primary Action -->
    <div class="flex justify-between items-end">
        <div class="space-y-1">
            <h2 class="text-[2.75rem] font-black tracking-tighter text-on-surface leading-none">Daftar Agenda</h2>
            <p class="text-on-surface-variant font-medium">Manage and organize your corporate meeting schedules</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-surface-container-low p-1 rounded-lg flex">
            </div>
            <button
                class="bg-linear-to-r from-tertiary to-tertiary-container text-on-tertiary px-6 py-3 rounded-md font-bold text-sm flex items-center gap-2 shadow-lg hover:brightness-110 transition-all active:scale-95">
                <span class="material-symbols-outlined">add_circle</span>
                Buat Agenda Baru
            </button>
        </div>
    </div>
    <!-- Filter Section (Editorial Style: No Borders, Tonal Background) -->
    <div class="bg-surface-container-low p-6 rounded-2xl flex flex-wrap items-end gap-6">
        <div class="space-y-2">
            <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-extrabold ml-1">Rentang
                Tanggal</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-primary text-sm">event</span>
                <input
                    class="bg-surface-container-lowest border-none rounded-md pl-10 pr-4 py-2.5 text-sm font-medium w-64 focus:ring-2 focus:ring-primary"
                    type="text" value="Oct 12, 2023 - Oct 28, 2023" />
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] uppercase tracking-widest text-on-surface-variant font-extrabold ml-1">Status
                Rapat</label>
            <select
                class="bg-surface-container-lowest border-none rounded-md pl-4 pr-10 py-2.5 text-sm font-medium w-48 focus:ring-2 focus:ring-primary appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M5%207.5L10%2012.5L15%207.5%22%20stroke%3D%22%23414754%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22/%3E%3C/svg%3E')] bg-size-[20px] bg-position-[right_10px_center] bg-no-repeat">
                <option>Semua Status</option>
                <option>Scheduled</option>
                <option>In Progress</option>
                <option>Completed</option>
            </select>
        </div>

        <button
            class="ml-auto bg-surface-container-high hover:bg-surface-container-highest text-on-surface px-5 py-2.5 rounded-md text-sm font-bold transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">tune</span>

        </button>
    </div>
    <!-- Agenda Table (Editorial Logic: No horizontal borders, spacing and tonal shifts only) -->
    <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-high">
                    <th class="px-6 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-on-surface-variant">
                        Judul Rapat</th>
                    <th class="px-6 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-on-surface-variant">
                        Tanggal &amp; Waktu</th>
                    <th class="px-6 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-on-surface-variant">
                        Lokasi</th>
                    <th
                        class="px-6 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-on-surface-variant text-center">
                        Peserta</th>
                    <th
                        class="px-6 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-on-surface-variant text-center">
                        Status</th>
                    <th
                        class="px-6 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-on-surface-variant text-right">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-transparent">
                <!-- Row 1 -->
                <tr class="group hover:bg-surface-container-low transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-8 bg-primary rounded-full"></div>
                            <div>
                                <p class="font-bold text-on-surface headline-sm">Quarterly Financial Review Q3</p>
                                <p class="text-xs text-on-surface-variant">Strategic Planning for Expansion</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <p class="font-semibold text-sm">24 Oct, 2023</p>
                        <p class="text-[11px] text-on-surface-variant">09:00 AM - 11:30 AM</p>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-primary">meeting_room</span>
                            <span class="text-sm font-medium">Executive Boardroom</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center -space-x-2">
                            <img alt="Avatar" class="w-7 h-7 rounded-full border-2 border-surface"
                                data-alt="portrait of a confident woman executive with soft lighting"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAv4KEG4pKQr4AfhVnNshjv4DN_AxHCb6vBfEHi5tzBhucnTShmTD1hKR2xzqmcbs5HhntKqf-DD3nincy8QUwxG9Hqv2ux8OJjVmXVKuQj8IvqCiarJ0ysEwJHGdlRE111Eznn3dtrRpYva5kIgI1IW-SOqzHq87i5ERzLPJqtMcxNlOXmeuRW14ZFk1h_sgJlf6s2eSukCCNu4_1IvTL50KoI6v09q2WhLXzjj6JBRHVT3JAdkM-rBpObReHAXxmRxD3Y3FxtLGKt" />
                            <img alt="Avatar" class="w-7 h-7 rounded-full border-2 border-surface"
                                data-alt="portrait of a male professional in a smart casual outfit"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBx0Zeh9b2Q9rmVt5PdsERdIXHCrNS_y4Ob5cxYBsr_2LFRKKbrgqYn2g6fI8_WHY11VfoXKWLBJXZ_7XVu-e27wQsVMuLBuMKAEmIPI7TURScslZz0TEiIoUgLuZ4pzibk3LFFZeLebiVa5duJVkjlZPkj4CHN1cPtT5fH5aDba4hCZusJsIKEn2IcLXNyHfjr4BIx1mC3pqIvDQ-gkvGD5JqKIj0h1TTxbPOV1cb42IaqYZSxiJ7-QDQEac9TCIsqyasNza5XRG3O" />
                            <div
                                class="w-7 h-7 rounded-full bg-primary-container text-[10px] font-bold flex items-center justify-center border-2 border-surface text-on-primary-container">
                                +8</div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span
                            class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">Scheduled</span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div
                            class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button
                                class="p-1.5 hover:bg-surface-container-highest rounded transition-colors text-on-surface-variant"
                                title="Detail">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                            <button
                                class="p-1.5 hover:bg-surface-container-highest rounded transition-colors text-primary"
                                title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                            <button
                                class="p-1.5 hover:bg-error-container hover:text-on-error-container rounded transition-colors text-error"
                                title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <!-- Row 2 -->
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="px-6 py-4 bg-surface-container-low flex justify-between items-center">
            <p class="text-xs text-on-surface-variant font-medium">Showing <span
                    class="text-on-surface font-bold">1-10</span> of <span class="text-on-surface font-bold">42</span>
                agendas</p>
            <div class="flex gap-2">
                <button
                    class="w-8 h-8 rounded bg-surface-container-lowest flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-on-primary transition-colors">
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </button>
                <button
                    class="w-8 h-8 rounded bg-primary text-on-primary font-bold text-xs flex items-center justify-center">1</button>
                <button
                    class="w-8 h-8 rounded bg-surface-container-lowest text-on-surface font-bold text-xs flex items-center justify-center hover:bg-surface-variant">2</button>
                <button
                    class="w-8 h-8 rounded bg-surface-container-lowest text-on-surface font-bold text-xs flex items-center justify-center hover:bg-surface-variant">3</button>
                <button
                    class="w-8 h-8 rounded bg-surface-container-lowest flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-on-primary transition-colors">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Bento Stats Grid (Modern UI Pattern) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div
            class="md:col-span-2 bg-linear-to-br from-primary-container to-primary p-6 rounded-3xl text-on-primary relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] uppercase tracking-widest font-extrabold opacity-80">Next Major Event</p>
                <h3 class="text-2xl font-black mt-2">Annual General Meeting</h3>
                <div class="mt-6 flex items-center gap-4">
                    <div class="bg-on-primary/10 p-3 rounded-xl backdrop-blur-md">
                        <p class="text-[10px] uppercase font-bold opacity-60">Days</p>
                        <p class="text-2xl font-black leading-none">12</p>
                    </div>
                    <div class="bg-on-primary/10 p-3 rounded-xl backdrop-blur-md">
                        <p class="text-[10px] uppercase font-bold opacity-60">Hours</p>
                        <p class="text-2xl font-black leading-none">08</p>
                    </div>
                    <div class="bg-on-primary/10 p-3 rounded-xl backdrop-blur-md">
                        <p class="text-[10px] uppercase font-bold opacity-60">Mins</p>
                        <p class="text-2xl font-black leading-none">45</p>
                    </div>
                </div>
            </div>
            <span
                class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] opacity-10 rotate-12 transition-transform group-hover:scale-110">rocket_launch</span>
        </div>
        <div class="bg-surface-container-high p-6 rounded-3xl flex flex-col justify-between">
            <div>
                <span class="material-symbols-outlined text-primary text-3xl">task_alt</span>
                <p class="text-[10px] uppercase tracking-widest font-extrabold text-on-surface-variant mt-4">Completed
                    This Week</p>
            </div>
            <div>
                <p class="text-4xl font-black text-on-surface">18</p>
                <p class="text-xs text-tertiary font-bold mt-1">+12% from last week</p>
            </div>
        </div>
        <div class="bg-surface-container-high p-6 rounded-3xl flex flex-col justify-between">
            <div>
                <span class="material-symbols-outlined text-error text-3xl">emergency</span>
                <p class="text-[10px] uppercase tracking-widest font-extrabold text-on-surface-variant mt-4">Urgent
                    Matters</p>
            </div>
            <div>
                <p class="text-4xl font-black text-on-surface">03</p>
                <p class="text-xs text-on-surface-variant mt-1">Requiring immediate action</p>
            </div>
        </div>
    </div>
</div>
</main> --}}


<div x-data="agendaStore()" x-init="init()">

    <button @click="openModal()" class="mb-4 bg-blue-500 text-white px-4 py-2">
        + Agenda
    </button>

    <div class="grid gap-4">

        <template x-for="item in agendas" :key="item.id">
            <div class="p-4 bg-white shadow rounded">

                <h3 class="font-bold" x-text="item.judul"></h3>

                <p x-text="item.lokasi?.nama_lokasi"></p>

                <div class="text-sm mt-2">
                    <b>Peserta:</b>
                    <template x-for="p in item.pesertas">
                        <span x-text="p.nama + ', '"></span>
                    </template>
                </div>

                <div class="mt-2">
                    <button @click="edit(item)" class="text-blue-500">Edit</button>
                    <button @click="remove(item.id)" class="text-red-500">Hapus</button>
                </div>

            </div>
        </template>

    </div>

    <!-- MODAL -->
    <div x-show="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center">

        <div class="bg-white p-6 w-150 rounded">

            <h2 class="font-bold mb-4">Form Agenda</h2>

            <input x-model="form.judul" placeholder="Judul" class="w-full mb-2 border p-2">

            <textarea x-model="form.deskripsi" class="w-full mb-2 border p-2"></textarea>

            <input type="date" x-model="form.tanggal" class="w-full mb-2 border p-2">

            <input type="datetime-local" x-model="form.waktu_mulai" class="w-full mb-2 border p-2">
            <input type="datetime-local" x-model="form.waktu_selesai" class="w-full mb-2 border p-2">

            <select x-model="form.lokasi_id" class="w-full mb-2 border p-2">
                <template x-for="l in lokasis">
                    <option :value="l.id" x-text="l.nama_lokasi"></option>
                </template>
            </select>

            <!-- PESERTA -->
            <!-- MULTI SELECT PESERTA -->
            <div class="mb-4" x-data="multiSelectPeserta($root)" x-init="init()">
                <label class="font-bold mb-1 block">Peserta</label>

                <!-- INPUT BOX -->
                <div @click="open = true"
                    class="min-h-10.5 w-full flex flex-wrap items-center gap-2 p-2 border rounded cursor-pointer">

                    <!-- Selected -->
                    <template x-for="item in selected" :key="item.id">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                            <span x-text="item.nama"></span>
                            <button @click.stop="remove(item)">✕</button>
                        </span>
                    </template>

                    <input x-model="search" @focus="open = true" @input="filter()" placeholder="Cari peserta..."
                        class="flex-1 outline-none text-sm">
                </div>

                <!-- DROPDOWN -->
                <div x-show="open" @click.away="open = false"
                    class="border rounded mt-1 max-h-40 overflow-auto bg-white shadow">

                    <template x-for="item in filtered" :key="item.id">
                        <div @click="toggle(item)"
                            class="px-3 py-2 cursor-pointer hover:bg-blue-50 flex justify-between">

                            <span x-text="item.nama"></span>

                            <span x-show="isSelected(item)">✔</span>
                        </div>
                    </template>

                </div>
            </div>

            <div class="mt-4 flex gap-2">
                <button @click="save()" class="bg-blue-500 text-white px-4 py-2">Simpan</button>
                <button @click="showModal=false">Batal</button>
            </div>

        </div>
    </div>


</div>
<script>
    function agendaStore() {
    return {
        agendas: [],
        pesertas: [],
        lokasis: [],

        showModal: false,
        editId: null,

        form: {
            judul: '',
            deskripsi: '',
            tanggal: '',
            waktu_mulai: '',
            waktu_selesai: '',
            lokasi_id: '',
            pesertas: []
        },

        async init() {
            this.agendas = await (await fetch('/agendas-data')).json();
            this.pesertas = await (await fetch('/pesertas-data')).json();
            this.lokasis = await (await fetch('/lokasis-data')).json();
        },

        openModal() {
            this.reset();
            this.showModal = true;
        },

        edit(data) {
            this.editId = data.id;

            this.form = {
                ...data,
                pesertas: data.pesertas.map(p => ({
                    id: p.id,
                    status: p.pivot.status,
                    catatan: p.pivot.catatan
                }))
            };

            this.showModal = true;
        },

        async save() {
            let url = '/agendas';
            let method = 'POST';

            if (this.editId) {
                url += '/' + this.editId;
                method = 'PUT';
            }

            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify(this.form)
            });

            const data = await res.json();

            if (this.editId) {
                const i = this.agendas.findIndex(a => a.id === data.id);
                this.agendas[i] = data;
            } else {
                this.agendas.unshift(data);
            }

            this.showModal = false;
        },

        async remove(id) {
            if (!confirm('Hapus agenda?')) return;

            await fetch(`/agendas/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                }
            });

            this.agendas = this.agendas.filter(a => a.id !== id);
        },

        reset() {
            this.form = {
                judul: '',
                deskripsi: '',
                tanggal: '',
                waktu_mulai: '',
                waktu_selesai: '',
                lokasi_id: '',
                pesertas: []
            };
            this.editId = null;
        }
    }
}
</script>



@endsection
@push('scripts')


<script>
    function multiSelectPeserta(root) {
    return {
        open: false,
        search: '',
        options: [],
        filtered: [],
        selected: [],

        init() {
            this.options = root.pesertas;
            this.filtered = this.options;

            // sync saat edit
            if (root.form.pesertas.length) {
                this.selected = root.form.pesertas.map(p =>
                    this.options.find(o => o.id === p.id)
                ).filter(Boolean);
            }
        },

        filter() {
            this.filtered = this.options.filter(o =>
                o.nama.toLowerCase().includes(this.search.toLowerCase())
            );
        },

        toggle(item) {
            const exist = this.selected.find(i => i.id === item.id);

            if (exist) {
                this.selected = this.selected.filter(i => i.id !== item.id);
            } else {
                this.selected.push(item);
            }

            this.sync();
        },

        remove(item) {
            this.selected = this.selected.filter(i => i.id !== item.id);
            this.sync();
        },

        isSelected(item) {
            return this.selected.some(i => i.id === item.id);
        },

        sync() {
            root.form.pesertas = this.selected.map(i => ({
                id: i.id,
                status: 'hadir',
                catatan: ''
            }));
        }
    }
}
</script>
@endpush