@extends('layouts.dashboard')

@section('content')
<div x-data="pesertaModal()" class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <span class="text-xs font-bold uppercase tracking-[0.2em] text-blue-600 mb-2 block">Directory</span>
            <h2 class="text-[2.75rem] font-extrabold text-gray-900 leading-tight tracking-tighter">Daftar Peserta</h2>
            <p class="text-gray-500 mt-2 max-w-md">Kelola dan organisasikan data peserta organisasi, jabatan, dan
                instansi mereka.</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="openAddModal()"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold shadow-lg shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all">
                <span class="material-symbols-outlined text-xl">person_add</span>
                Tambah Peserta
            </button>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Nama & Email
                        </th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Jabatan</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Instansi</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-gray-400">Tipe</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-gray-400 text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pesertas as $p)
                    <tr class="group hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                    {{ strtoupper(substr($p->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $p->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $p->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-gray-600 font-medium">{{ $p->jabatan ?? '-' }}</td>
                        <td class="px-6 py-6 text-gray-600">{{ $p->instansi ?? '-' }}</td>
                        <td class="px-6 py-6">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold {{ $p->tipe == 'internal' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ ucfirst($p->tipe) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <button @click="openEditModal({{ $p }})"
                                    class="p-2 hover:bg-yellow-50 rounded-lg text-yellow-600 transition-colors">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <form action="{{ route('peserta.destroy', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus peserta ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-2 hover:bg-red-50 rounded-lg text-red-600 transition-colors">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-gray-400">Belum ada data peserta.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="isOpen" x-cloak class="fixed inset-0 z-[999] overflow-y-auto">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="isOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl p-8 overflow-hidden"
                    @click.away="isOpen = false">

                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-gray-900"
                            x-text="editMode ? 'Edit Data Peserta' : 'Tambah Peserta Baru'"></h3>
                        <p class="text-gray-500">Pastikan informasi email dan nomor telepon sudah benar.</p>
                    </div>

                    <form :action="editMode ? `/peserta/${formData.id}` : '/peserta'" method="POST">
                        @csrf
                        <template x-if="editMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Nama Lengkap</label>
                                <input type="text" name="nama" x-model="formData.nama" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Email</label>
                                <input type="email" name="email" x-model="formData.email" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Nomor Telepon</label>
                                <input type="text" name="no_tlp" x-model="formData.no_tlp" required
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Tipe Peserta</label>
                                <select name="tipe" x-model="formData.tipe"
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 transition-all appearance-none">
                                    <option value="internal">Internal</option>
                                    <option value="external">External</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Jabatan</label>
                                <input type="text" name="jabatan" x-model="formData.jabatan"
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 ml-1">Instansi</label>
                                <input type="text" name="instansi" x-model="formData.instansi"
                                    class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end gap-3">
                            <button type="button" @click="isOpen = false"
                                class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all">Batal</button>
                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<script>
    function pesertaModal() {
        return {
            isOpen: false,
            editMode: false,
            formData: {
                id: '',
                nama: '',
                email: '',
                no_tlp: '',
                tipe: 'internal',
                jabatan: '',
                instansi: ''
            },
            openAddModal() {
                this.editMode = false;
                this.formData = { id: '', nama: '', email: '', no_tlp: '', tipe: 'internal', jabatan: '', instansi: '' };
                this.isOpen = true;
            },
            openEditModal(peserta) {
                this.editMode = true;
                this.formData = {
                    id: peserta.id,
                    nama: peserta.nama,
                    email: peserta.email,
                    no_tlp: peserta.no_tlp,
                    tipe: peserta.tipe ?? 'internal',
                    jabatan: peserta.jabatan,
                    instansi: peserta.instansi
                };
                this.isOpen = true;
            }
        }
    }
</script>
@endsection