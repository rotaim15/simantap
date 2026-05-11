@extends('layouts.dashboard')

@section('content')
<div class="py-12" x-data="agendaCrud()">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Agenda</h2>
            <button @click="openCreate()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah Agenda
            </button>
        </div>

        <!-- TABLE -->
        <div class="bg-white shadow-sm rounded-lg">
            <table class="min-w-full">
                <tbody>
                    @foreach($agendas as $agenda)
                    <tr>
                        <td class="p-4">{{ $agenda->judul }}</td>
                        <td class="p-4">{{ $agenda->lokasi->nama ?? '-' }}</td>
                        <td class="p-4">
                            <button @click="openEdit({{ $agenda->toJson() }})" class="text-indigo-600">Edit</button>
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
    <div x-show="isModalOpen" class="fixed inset-0 z-[9999] flex items-center justify-center">

        <div class="absolute inset-0 bg-black/40" @click="closeModal()"></div>

        <div @click.stop class="bg-white w-full max-w-3xl rounded-xl p-6 shadow-lg">

            <h3 class="text-xl font-semibold mb-4" x-text="isEdit ? 'Edit Agenda' : 'Tambah Agenda Baru'"></h3>

            <form :action="formAction" method="POST" class="space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <input type="text" name="judul" x-model="form.judul" class="w-full border rounded p-2"
                    placeholder="Judul">

                <textarea name="deskripsi" x-model="form.deskripsi" class="w-full border rounded p-2"
                    placeholder="Deskripsi"></textarea>

                <!-- lokasi -->
                <select name="lokasi_id" x-model="form.lokasi_id" class="w-full border rounded p-2">
                    <option value="">Pilih Lokasi</option>
                    @foreach($lokasis as $lok)
                    <option value="{{ $lok->id }}">{{ $lok->nama }}</option>
                    @endforeach
                </select>

                <input type="date" name="tanggal" x-model="form.tanggal" class="w-full border rounded p-2">

                <input type="datetime-local" name="waktu_mulai" x-model="form.waktu_mulai"
                    class="w-full border rounded p-2">

                <!-- ========================= -->
                <!-- MULTI SELECT PESERTA -->
                <!-- ========================= -->
                <div @click.away="searchOpen = false">
                    <label class="text-sm">Peserta</label>

                    <div class="border rounded p-2 flex flex-wrap gap-2"
                        @click="searchOpen = true; $refs.searchInput.focus()">

                        <template x-for="id in selectedPesertas" :key="id">
                            <span class="bg-indigo-100 px-2 py-1 rounded text-sm">
                                <span x-text="getPesertaName(id)"></span>
                                <button @click.stop="togglePeserta(id)">x</button>
                            </span>
                        </template>

                        <input x-ref="searchInput" x-model="searchQuery" class="flex-1 outline-none"
                            placeholder="Cari peserta...">
                    </div>

                    <!-- dropdown -->
                    <div x-show="searchOpen" class="bg-white border mt-1 rounded shadow max-h-40 overflow-auto">

                        <template x-for="p in filteredPesertas()" :key="p.id">
                            <div @click="togglePeserta(p.id)" class="p-2 hover:bg-indigo-50 cursor-pointer"
                                x-text="p.nama"></div>
                        </template>

                        <div x-show="filteredPesertas().length === 0" class="p-2 text-gray-400">
                            Tidak ditemukan
                        </div>

                        <!-- tombol tambah -->
                        <div x-show="searchQuery.length > 0" @click="openPesertaModal()"
                            class="p-2 text-indigo-600 cursor-pointer border-t">
                            + Tambah "<span x-text="searchQuery"></span>"
                        </div>
                    </div>

                    <template x-for="id in selectedPesertas">
                        <input type="hidden" name="peserta_ids[]" :value="id">
                    </template>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="closeModal()" class="border px-4 py-2 rounded">Batal</button>
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================= -->
    <!-- MODAL TAMBAH PESERTA -->
    <!-- ========================= -->
    <div x-show="isPesertaModalOpen" class="fixed inset-0 z-[9999] flex items-center justify-center">

        <div class="absolute inset-0 bg-black/40" @click="isPesertaModalOpen = false"></div>

        <div @click.stop class="bg-white w-full max-w-md rounded-xl p-6 shadow">

            <h3 class="font-semibold mb-4">Tambah Peserta</h3>

            <input x-model="newPesertaName" class="w-full border p-2 rounded mb-4" placeholder="Nama peserta">

            <div class="flex justify-end gap-2">
                <button @click="isPesertaModalOpen = false" class="border px-4 py-2 rounded">Batal</button>

                <button @click="savePeserta()" class="bg-indigo-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
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

    form: { id:null, judul:'', deskripsi:'', tanggal:'', waktu_mulai:'', lokasi_id:'' },

    allPesertas: @json($pesertas),
    selectedPesertas: [],
    searchQuery: '',
    searchOpen: false,

    // peserta modal
    isPesertaModalOpen: false,
    newPesertaName: '',

    openCreate(){
        this.isEdit = false;
        this.form = {};
        this.selectedPesertas = [];
        this.isModalOpen = true;
    },

    openEdit(data){
        this.isEdit = true;
        this.form = data;
        this.selectedPesertas = data.pesertas ? data.pesertas.map(p => p.id) : [];
        this.isModalOpen = true;
    },

    closeModal(){
        this.isModalOpen = false;
    },

    filteredPesertas(){
        return this.allPesertas.filter(p =>
            p.nama.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
    },

    togglePeserta(id){
        const i = this.selectedPesertas.indexOf(id);
        if(i > -1) this.selectedPesertas.splice(i,1);
        else this.selectedPesertas.push(id);

        this.searchOpen = false;
        this.searchQuery = '';
    },

    getPesertaName(id){
        return this.allPesertas.find(p => p.id === id)?.nama;
    },

    openPesertaModal(){
        this.newPesertaName = this.searchQuery;
        this.isPesertaModalOpen = true;
    },

    async savePeserta(){
        if(!this.newPesertaName) return;

        const res = await fetch('/peserta',{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({ nama:this.newPesertaName })
        });

        const data = await res.json();

        this.allPesertas.push(data);
        this.selectedPesertas.push(data.id);

        this.isPesertaModalOpen = false;
        this.searchOpen = false;
        this.searchQuery = '';
    }

}))
})
</script>
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="py-12" x-data="agendaCrud()">
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
    <!-- ✅ MODAL -->
    <div x-show="isModalOpen && !isPesertaModalOpen" x-transition
        class="fixed inset-0 z-9999 flex items-center justify-center">

        <!-- BACKDROP -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="closeModal()"></div>

        <!-- MODAL BOX -->
        <div @click.stop class="relative bg-white w-full max-w-3xl rounded-2xl shadow-xl p-6">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800" x-text="isEdit ? 'Edit Agenda' : 'Tambah Agenda Baru'">
                </h3>

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
                    <label class="text-sm font-medium text-gray-700">
                        Judul Agenda <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" x-model="form.judul" placeholder="Masukkan judul agenda"
                        class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" x-model="form.deskripsi" placeholder="Masukkan deskripsi agenda" rows="3"
                        class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>



                <!-- GRID TANGGAL & WAKTU -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" x-model="form.tanggal"
                            class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Waktu Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="waktu_mulai" x-model="form.waktu_mulai"
                            class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>
                </div>

                <!-- WAKTU SELESAI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Waktu Selesai</label>
                        <input type="datetime-local" name="waktu_selesai" x-model="form.waktu_selesai"
                            class="w-full mt-1 border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <!-- Lokasi -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <select name="lokasi_id" x-model="form.lokasi_id"
                            class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Lokasi</option>
                            @foreach($lokasis as $lok)
                            <option value="{{ $lok->id }}">{{ $lok->nama_lokasi }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- PESERTA -->
                <div @click.away="searchOpen = false">
                    <label class="text-sm font-medium text-gray-700">Pilih Peserta</label>

                    <div class="mt-1 border rounded-lg p-2 flex flex-wrap gap-2 cursor-text"
                        @click="searchOpen = true; $refs.searchInput.focus()">

                        <template x-for="id in selectedPesertas" :key="id">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm flex items-center">
                                <span x-text="getPesertaName(id)"></span>
                                <button @click.stop="togglePeserta(id)" class="ml-1 text-xs">✕</button>
                            </span>
                        </template>

                        <input x-ref="searchInput" type="text" x-model="searchQuery"
                            placeholder="Klik untuk memilih peserta..." class="flex-1 outline-none">
                    </div>

                    <!-- DROPDOWN -->
                    <div x-show="searchOpen"
                        class="absolute bg-white border mt-1 w-full max-w-2xl rounded-lg shadow max-h-60 overflow-auto z-50">

                        <template x-for="p in filteredPesertas()" :key="p.id">
                            <div @click="togglePeserta(p.id)" class="px-3 py-2 hover:bg-blue-50 cursor-pointer"
                                :class="selectedPesertas.includes(p.id) ? 'bg-blue-100' : ''">
                                <span x-text="p.nama"></span>
                            </div>
                        </template>

                        <div x-show="filteredPesertas().length === 0" class="px-3 py-2 text-gray-400">
                            Tidak ditemukan
                        </div>

                        <a x-show="searchQuery.length > 0" :href="`/peserta/create?nama=${searchQuery}`" target="_blank"
                            class="block px-3 py-2 text-indigo-600 cursor-pointer hover:bg-indigo-50 border-t">

                            + Tambah "<span x-text="searchQuery"></span>"
                        </a>
                    </div>

                    <template x-for="id in selectedPesertas" :key="id">
                        <input type="hidden" name="peserta_ids[]" :value="id">
                    </template>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" @click="closeModal()"
                        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">
                        Batal
                    </button>

                    <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                        Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================= -->
    <!-- MODAL TAMBAH PESERTA -->
    <!-- ========================= -->
    <div x-show="isPesertaModalOpen" x-trap="isPesertaModalOpen"
        class="fixed inset-0 z-10000 flex items-center justify-center">

        <!-- backdrop -->
        <div class="absolute inset-0 bg-black/40" @click="isPesertaModalOpen = false"></div>

        <!-- modal -->
        <div @click.stop class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">

            <h3 class="text-lg font-semibold mb-4">Tambah Peserta Baru</h3>

            <input type="text" x-model="newPesertaName" class="w-full border rounded-lg p-2 mb-4"
                x-ref.inert="pesertaInput" placeholder="Nama peserta">

            <div class="flex justify-end gap-2">
                <button @click="isPesertaModalOpen = false" class="px-4 py-2 border rounded">
                    Batal
                </button>

                <button @click="savePeserta()" class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================= -->
<!-- ✅ ALPINE JS -->
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
        isPesertaModalOpen: false,
        newPesertaName: '',


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
            this.searchQuery = '';
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

            this.selectedPesertas = data.pesertas ? data.pesertas.map(p => p.id) : [];
            this.searchQuery = '';
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

        // hanya close saat add
        this.searchOpen = false;
        this.searchQuery = '';
    }
},

        getPesertaName(id) {
            const p = this.allPesertas.find(x => x.id === id);
            return p ? p.nama : 'Unknown';
        },
        openPesertaModal(){
    this.searchOpen = false; // 🔥 penting
    this.newPesertaName = this.searchQuery;
    this.isPesertaModalOpen = true;
    this.$nextTick(() => {
        this.$refs.pesertaInput.focus();
    });
},

async savePeserta(){
    if(!this.newPesertaName) return;

    try {
        const res = await fetch('/peserta', {
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({
                nama: this.newPesertaName
            })
        });

        // ❗ cek error
        if (!res.ok) {
            throw new Error('Gagal request');
        }

        const data = await res.json();

        // tambah ke list
        this.allPesertas.push(data);

        // auto select
        this.selectedPesertas.push(data.id);

        // reset
        this.newPesertaName = '';
        this.isPesertaModalOpen = false;
        this.searchOpen = false;
        this.searchQuery = '';

    } catch (err) {
        console.error(err);
        alert('Gagal menyimpan peserta');
    }
},


    }))
})

</script>
<script>
    window.addEventListener('focus', () => {
    fetch('/api/peserta')
        .then(res => res.json())
        .then(data => {
            this.allPesertas = data;
        });
});
</script>
@endsection