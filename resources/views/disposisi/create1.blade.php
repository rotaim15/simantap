@extends('layouts.app')

@section('title', 'Buat Disposisi Baru')
@section('page-title', 'Buat Disposisi Baru')

@section('breadcrumb')
<span>Beranda</span> /
<a href="{{ route('disposisi.index') }}" class="text-primary-600 hover:underline">Disposisi</a> /
<span class="text-slate-600">Tambah Disposisi</span>
@endsection

@section('content')
<div class="space-y-5">
    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Form Buat Disposisi</h2>
            <p class="text-sm text-slate-500">Buat disposisi baru untuk surat masuk yang diterima</p>
        </div>
        <a href="{{ route('disposisi.index') }}"
            class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('disposisi.store') }}" method="POST" class="space-y-5" x-data="disposisiForm()">
        @csrf

        <input type="hidden" name="surat_masuk_id" value="{{ $suratMasuk->id ?? '' }}" id="surat_masuk_id_hidden">

        {{-- Pilih Surat Masuk (jika tidak dikirim dari halaman surat masuk) --}}
        @if(!isset($suratMasuk) || !$suratMasuk)
        <div class="card">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-800">Pilih Surat Masuk</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pilih surat masuk yang akan didisposisikan</p>
            </div>
            <div class="p-5">
                <select name="surat_masuk_id" id="surat_masuk_id" required
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    <option value="">-- Pilih Surat Masuk --</option>
                    @foreach($suratMasukList as $surat)
                    <option value="{{ $surat->id }}" {{ old('surat_masuk_id')==$surat->id ? 'selected' : '' }}>
                        [{{ $surat->no_agenda }}] {{ $surat->perihal }} - {{ $surat->asal_surat }}
                    </option>
                    @endforeach
                </select>
                @error('surat_masuk_id')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        @else
        {{-- Tampilkan informasi surat yang dipilih --}}
        <div class="card bg-primary-50 border-primary-200">
            <div class="px-5 py-4 border-b border-primary-100">
                <h3 class="text-base font-semibold text-primary-800">Surat Yang Akan Didisposisikan</h3>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-slate-500">No. Agenda</label>
                        <p class="text-sm font-semibold text-slate-800">{{ $suratMasuk->no_agenda }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-slate-500">No. Surat</label>
                        <p class="text-sm font-semibold text-slate-800">{{ $suratMasuk->no_surat }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-slate-500">Perihal</label>
                        <p class="text-sm text-slate-800">{{ $suratMasuk->perihal }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-slate-500">Asal Surat</label>
                        <p class="text-sm text-slate-800">{{ $suratMasuk->asal_surat }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-slate-500">Tanggal Surat</label>
                        <p class="text-sm text-slate-800">{{ $suratMasuk->tanggal_surat->isoFormat('D MMMM Y') }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-slate-500">Tanggal Terima</label>
                        <p class="text-sm text-slate-800">{{ $suratMasuk->tanggal_terima->isoFormat('D MMMM Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Kode Disposisi --}}
        <div class="card">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-800">Informasi Disposisi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kode disposisi akan digenerate otomatis</p>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kode Disposisi</label>
                        <div class="bg-slate-100 rounded-xl px-4 py-2.5">
                            <span class="text-sm font-mono font-semibold text-primary-700">{{ $kodeDisposisi }}</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">* Kode akan tersimpan secara otomatis</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Disposisi <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_disposisi"
                            value="{{ old('tanggal_disposisi', date('Y-m-d')) }}" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        @error('tanggal_disposisi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Batas Waktu</label>
                        <input type="date" name="batas_waktu" value="{{ old('batas_waktu') }}"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        <p class="text-xs text-slate-400 mt-1">* Kosongkan jika tidak ada batas waktu</p>
                        @error('batas_waktu')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Prioritas <span
                                class="text-red-500">*</span></label>
                        <select name="prioritas" required
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                            <option value="rendah" {{ old('prioritas')=='rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="normal" {{ old('prioritas')=='normal' ? 'selected' : '' }}>Normal</option>
                            <option value="tinggi" {{ old('prioritas')=='tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="segera" {{ old('prioritas')=='segera' ? 'selected' : '' }}>Segera</option>
                        </select>
                        @error('prioritas')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Instruksi dan Catatan --}}
        <div class="card">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-800">Instruksi Disposisi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Isi instruksi dan catatan untuk penerima disposisi</p>
            </div>
            <div class="p-5 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Instruksi <span
                            class="text-red-500">*</span></label>
                    <textarea name="instruksi" rows="4" required
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                        placeholder="Tulis instruksi disposisi...">{{ old('instruksi') }}</textarea>
                    @error('instruksi')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="3"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                        placeholder="Tulis catatan tambahan...">{{ old('catatan') }}</textarea>
                    @error('catatan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Penerima --}}
        <div class="card">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-800">Penerima Disposisi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pilih pegawai yang akan menerima disposisi ini</p>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($users as $user)
                    <label
                        class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                        <input type="checkbox" name="penerima[]" value="{{ $user->id }}"
                            class="w-4 h-4 text-primary-600 rounded border-slate-300 focus:ring-primary-500" {{
                            in_array($user->id, old('penerima', [])) ? 'checked' : '' }}>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-slate-700">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 capitalize">{{ $user->jabatan ?? $user->role }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('penerima')
                <p class="text-xs text-red-500 mt-3">{{ $message }}</p>
                @enderror
                @error('penerima.*')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tindakan --}}
        <div class="card">
            <div class="px-5 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Daftar Tindakan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tambahkan daftar tindakan yang harus dikerjakan (opsional)
                    </p>
                </div>
                <button type="button" @click="addTindakan()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-50 hover:bg-primary-100 text-primary-700 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Tindakan
                </button>
            </div>
            <div class="p-5 space-y-3" id="tindakan-container">
                <template x-for="(tindakan, index) in tindakanList" :key="index">
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <input type="text" :name="`tindakan[${index}]`" x-model="tindakanList[index]"
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                placeholder="Contoh: Untuk ditindaklanjuti">
                        </div>
                        <button type="button" @click="removeTindakan(index)"
                            class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </template>

                {{-- Tindakan default dari controller --}}
                @foreach($tindakanDefault as $index => $tindakan)
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <input type="text" name="tindakan[{{ $index }}]" value="{{ $tindakan }}"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Contoh: Untuk ditindaklanjuti">
                    </div>
                    <button type="button" onclick="this.closest('.flex').remove()"
                        class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('disposisi.index') }}"
                class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Disposisi
            </button>
        </div>
    </form>
</div>

<script>
    function disposisiForm() {
        return {
            tindakanList: [],
            addTindakan() {
                this.tindakanList.push('');
            },
            removeTindakan(index) {
                this.tindakanList.splice(index, 1);
            }
        }
    }

    // Untuk menghapus tindakan default
    document.querySelectorAll('#tindakan-container .flex').forEach(container => {
        const deleteBtn = container.querySelector('button');
        if (deleteBtn && !deleteBtn.hasAttribute('@click')) {
            // Sudah memiliki event handler dari HTML
        }
    });
</script>
@endsection