@extends('layouts.dashboard')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    .editorial-shadow {
        box-shadow: 0 32px 64px -12px rgba(25, 28, 29, 0.04);
    }

    [x-cloak] {
        display: none !important;
    }
</style>
@endpush

@section('content')
<div x-data="lokasiCrud()" class="pt-24 px-10 pb-12">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-[2.75rem] font-black tracking-tight leading-none text-on-surface mb-2">Daftar Lokasi</h2>
            <p class="text-on-surface-variant max-w-md">Kelola ruangan dan fasilitas sekolah untuk penjadwalan agenda
                rapat yang lebih tertata.</p>
        </div>
        <button @click="openModal('create')"
            class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold shadow-lg hover:bg-primary/90 transition-all active:scale-95">
            <span class="material-symbols-outlined">add</span>
            <span>Add New Location</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($lokasis as $l)
        <div id="card-lokasi-{{ $l->id }}"
            class="group bg-white rounded-xl overflow-hidden editorial-shadow border border-outline-variant/10 transition-all hover:translate-y-[-4px]">
            <div class="relative h-40 bg-gray-100">
                <img class="w-full h-full object-cover opacity-80"
                    src="https://plus.unsplash.com/premium_photo-1670071482460-5c08776521fe?q=80&w=500&auto=format&fit=crop" />
                <div class="absolute top-4 left-4">
                    <span
                        class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full {{ $l->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $l->status }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 truncate">{{ $l->nama_lokasi }}</h3>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            {{ $l->alamat ?? 'Alamat belum diset' }}
                        </p>
                    </div>
                    <div class="flex gap-1">
                        <button @click="openModal('edit', {{ json_encode($l) }})"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </button>
                        <button @click="deleteData({{ $l->id }})"
                            class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors">
                            <span class="material-symbols-outlined text-[20px]">delete</span>
                        </button>
                    </div>
                </div>
                <div
                    class="pt-4 border-t border-gray-100 flex justify-between items-center text-xs font-bold text-gray-400">
                    <span>KAPASITAS: {{ $l->kapasitas ?? '0' }}</span>
                </div>
            </div>
        </div>
        @endforeach

        <div @click="openModal('create')"
            class="group border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center p-12 text-center hover:border-primary/50 transition-colors cursor-pointer">
            <div
                class="h-14 w-14 bg-gray-50 rounded-full flex items-center justify-center mb-4 group-hover:bg-primary/10 transition-colors">
                <span
                    class="material-symbols-outlined text-3xl text-gray-400 group-hover:text-primary">add_location_alt</span>
            </div>
            <h3 class="font-bold text-gray-700">Tambah Lokasi</h3>
            <p class="text-xs text-gray-400 mt-1">Klik untuk menambah ruang</p>
        </div>
    </div>

    <div x-show="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
        <div x-show="isModalOpen" x-transition.opacity x-transition.scale
            class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="isModalOpen = false"></div>

        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

            <div class="px-8 py-6 border-b flex justify-between items-center">
                <h3 class="text-xl font-black text-gray-900"
                    x-text="mode === 'create' ? 'Tambah Lokasi Baru' : 'Edit Lokasi'"></h3>
                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600"><span
                        class="material-symbols-outlined">close</span></button>
            </div>

            <form @submit.prevent="submitForm" class="p-8">
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Nama
                            Lokasi</label>
                        <input type="text" x-model="formData.nama_lokasi"
                            class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary"
                            placeholder="Contoh: Ruang Meeting A" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Alamat /
                            Letak</label>
                        <textarea x-model="formData.alamat" rows="2"
                            class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary"
                            placeholder="Lantai 2, Gedung Barat"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Kapasitas</label>
                            <input type="number" x-model.number="formData.kapasitas"
                                class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Koordinat</label>
                            <input type="text" x-model="formData.koordinat"
                                class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary"
                                placeholder="-6.200000, 106.816666">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Keterangan</label>
                            <textarea x-model="formData.keterangan" rows="2"
                                class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary"
                                placeholder="Catatan tambahan..."></textarea>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Status</label>
                            <select x-model="formData.status"
                                class="w-full bg-gray-50 border-none rounded-xl p-3 focus:ring-2 focus:ring-primary">
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <button type="button" @click="isModalOpen = false"
                        class="px-6 py-3 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="px-8 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50"
                        :class="isLoading ? 'cursor-not-allowed opacity-50' : ''">
                        <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Data'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function lokasiCrud() {
    return {
        isModalOpen: false,
        mode: 'create',
        isLoading: false,
        selectedId: null,

        formData: {
            nama_lokasi: '',
            alamat: '',
            koordinat: '',
            kapasitas: '',
            keterangan: '',
            status: 'aktif'
        },

        openModal(mode, data = null) {
            this.mode = mode;
            this.isModalOpen = true;

            if (mode === 'edit' && data) {
                this.selectedId = data.id;
                this.formData = { ...data };
            } else {
                this.resetForm();
            }
        },

        resetForm() {
            this.formData = {
                nama_lokasi: '',
                alamat: '',
                koordinat: '',
                kapasitas: '',
                keterangan: '',
                status: 'aktif'
            };
            this.selectedId = null;
        },

        async submitForm() {
            this.isLoading = true;

            let url = '/lokasi';
            let method = 'POST';

            if (this.mode === 'edit') {
                url = `/lokasi/${this.selectedId}`;
                method = 'PUT';
            }

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.formData)
                });

                const data = await res.json();

                alert(data.message);
                location.reload();

            } catch (err) {
                console.error(err);
                alert('Terjadi error');
            }

            this.isLoading = false;
        },

        async deleteData(id) {
            if (!confirm('Yakin mau hapus?')) return;

            try {
                const res = await fetch(`/lokasi/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await res.json();

                document.getElementById(`card-lokasi-${id}`).remove();

                alert(data.message);

            } catch (err) {
                console.error(err);
                alert('Gagal hapus');
            }
        }
    }
}
</script>
@endpush