@extends('layouts.dashboard')

@section('content')
<div class="py-12" x-data="agendaCrud()" x-init="init()">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Agenda</h2>
            <button @click="openCreate()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah Agenda
            </button>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- TABLE -->
        <div class="bg-white shadow-sm sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs text-gray-500 uppercase">Peserta</th>
                        <th class="px-6 py-3 text-center text-xs text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($agendas as $agenda)
                    <tr>
                        <td class="px-6 py-4">{{ $agenda->judul }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">{{ $agenda->lokasi->nama ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @foreach($agenda->pesertas->take(3) as $p)
                            <span class="bg-gray-100 text-xs px-2 py-1 rounded">{{ $p->nama }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button @click="openEdit({{ $agenda->toJson() }})"
                                class="text-indigo-600 mr-2">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================= -->
    <!-- MODAL AGENDA -->
    <!-- ========================= -->
    <div x-show="isModalOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center">

        <!-- backdrop -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="closeModal()"></div>

        <!-- modal -->
        <div @click.stop class="relative bg-white w-full max-w-3xl rounded-2xl shadow-xl p-6">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold" x-text="isEdit ? 'Edit Agenda' : 'Tambah Agenda Baru'"></h3>

                <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl">
                    ✕
                </button>
            </div>

            <form :action="formAction" method="POST" class="space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <!-- Judul -->
                <div>
                    <label class="text-sm font-medium">Judul Agenda *</label>
                    <input type="text" name="judul" x-model="form.judul" class="w-full mt-1 border rounded-lg">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" x-model="form.deskripsi"
                        class="w-full mt-1 border rounded-lg"></textarea>
                </div>

                <!-- GRID -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Tanggal *</label>
                        <input type="date" name="tanggal" x-model="form.tanggal" class="w-full border rounded-lg">
                    </div>

                    <div>
                        <label>Waktu Mulai *</label>
                        <input type="datetime-local" name="waktu_mulai" x-model="form.waktu_mulai"
                            class="w-full border rounded-lg">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Waktu Selesai</label>
                        <input type="datetime-local" name="waktu_selesai" x-model="form.waktu_selesai"
                            class="w-full border rounded-lg">
                    </div>

                    <div>
                        <label>Lokasi *</label>
                        <select name="lokasi_id" x-model="form.lokasi_id" class="w-full border rounded-lg">
                            <option value="">Pilih Lokasi</option>
                            @foreach($lokasis as $lok)
                            <option value="{{ $lok->id }}">{{ $lok->nama_lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- PESERTA -->
                <div @click.away="searchOpen = false">
                    <label>Pilih Peserta</label>

                    <div class="border rounded-lg p-2 flex flex-wrap gap-2"
                        @click="searchOpen = true; $refs.searchInput.focus()">

                        <template x-for="id in selectedPesertas" :key="id">
                            <span class="bg-blue-100 px-2 py-1 rounded text-sm flex items-center">
                                <span x-text="getPesertaName(id)"></span>
                                <button @click.stop="togglePeserta(id)">✕</button>
                            </span>
                        </template>

                        <input x-ref="searchInput" x-model="searchQuery" class="flex-1 outline-none"
                            placeholder="Cari peserta...">
                    </div>

                    <!-- dropdown -->
                    <div x-show="searchOpen"
                        class="absolute bg-white border w-full max-w-2xl rounded shadow max-h-60 overflow-auto z-50">

                        <template x-for="p in filteredPesertas()" :key="p.id">
                            <div @click="togglePeserta(p.id)" class="px-3 py-2 hover:bg-blue-50 cursor-pointer"
                                :class="selectedPesertas.includes(p.id) ? 'bg-blue-100' : ''">
                                <span x-text="p.nama"></span>
                            </div>
                        </template>

                        <div x-show="filteredPesertas().length === 0" class="px-3 py-2 text-gray-400">
                            Tidak ditemukan
                        </div>

                        <!-- tambah peserta -->
                        <a x-show="searchQuery.length > 0" :href="`/peserta/create?nama=${searchQuery}`" target="_blank"
                            class="block px-3 py-2 text-indigo-600 hover:bg-indigo-50 border-t">
                            + Tambah "<span x-text="searchQuery"></span>"
                        </a>
                    </div>

                    <template x-for="id in selectedPesertas" :key="id">
                        <input type="hidden" name="peserta_ids[]" :value="id">
                    </template>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-2 pt-4 border-t">
                    <button type="button" @click="closeModal()" class="px-4 py-2 border rounded">Batal</button>

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                        Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================= -->
<!-- ALPINE JS -->
<!-- ========================= -->
<script>
    document.addEventListener('alpine:init', () => {
    Alpine.data('agendaCrud', () => ({

        isModalOpen: false,
        isEdit: false,
        formAction: '{{ route('agendas.store') }}',

        form: {
            id: null,
            judul: '',
            deskripsi: '',
            tanggal: '',
            waktu_mulai: '',
            waktu_selesai: '',
            lokasi_id: ''
        },

        allPesertas: @json($pesertas),
        selectedPesertas: [],
        searchQuery: '',
        searchOpen: false,

        init() {
            window.addEventListener('focus', () => {
                this.refreshPeserta();
            });
        },

        async refreshPeserta() {
            try {
                const res = await fetch('/api/peserta');
                const data = await res.json();
                this.allPesertas = data;
            } catch (e) {
                console.error('Gagal refresh peserta');
            }
        },

        openCreate() {
            this.isEdit = false;
            this.formAction = '{{ route('agendas.store') }}';

            this.form = {
                id: null,
                judul: '',
                deskripsi: '',
                tanggal: '',
                waktu_mulai: '',
                waktu_selesai: '',
                lokasi_id: ''
            };

            this.selectedPesertas = [];
            this.isModalOpen = true;
        },

        openEdit(data) {
            this.isEdit = true;
            this.formAction = `/agendas/${data.id}`;

            const format = (dt) => dt ? dt.slice(0,16) : '';

            this.form = {
                id: data.id,
                judul: data.judul,
                deskripsi: data.deskripsi,
                tanggal: data.tanggal,
                waktu_mulai: format(data.waktu_mulai),
                waktu_selesai: format(data.waktu_selesai),
                lokasi_id: data.lokasi_id ? String(data.lokasi_id) : ''
            };

            this.selectedPesertas = data.pesertas
                ? data.pesertas.map(p => p.id)
                : [];

            this.isModalOpen = true;
        },

        closeModal() {
            this.isModalOpen = false;
        },

        filteredPesertas() {
            if (!this.searchQuery) return this.allPesertas;

            return this.allPesertas.filter(p =>
                p.nama.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },

        togglePeserta(id) {
            const i = this.selectedPesertas.indexOf(id);

            if (i > -1) {
                this.selectedPesertas.splice(i, 1);
            } else {
                this.selectedPesertas.push(id);
                this.searchOpen = false;
                this.searchQuery = '';
            }
        },

        getPesertaName(id) {
            const p = this.allPesertas.find(x => x.id === id);
            return p ? p.nama : 'Unknown';
        }

    }))
})
</script>
@endsection