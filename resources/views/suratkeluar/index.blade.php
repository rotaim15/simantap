@extends('layouts.app')

@section('title', 'Surat Keluar')
@section('page-title', 'Surat Keluar')

@section('breadcrumb')
    <span>Beranda</span> / <span class="text-slate-600">Surat Keluar</span>
@endsection

@section('content')
<div class="space-y-5" x-data="{ showFilter: false }">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Surat Keluar</h2>
            <p class="text-sm text-slate-500">Kelola seluruh surat keluar instansi</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('surat-keluar.create') }}"
           class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm shadow-emerald-500/20">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Surat Keluar
        </a>
        @endif
    </div>

    {{-- Stats mini --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
            $totalAll    = $suratKeluar->total();
            $totalDraft  = \App\Models\SuratKeluar::where('status', 'draft')->count();
            $totalKirim  = \App\Models\SuratKeluar::where('status', 'terkirim')->count();
            $totalTerima = \App\Models\SuratKeluar::where('status', 'diterima')->count();
        @endphp
        <div class="bg-white rounded-xl border border-slate-100 px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-slate-800">{{ $totalAll }}</p>
                <p class="text-xs text-slate-500">Total</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-slate-800">{{ $totalDraft }}</p>
                <p class="text-xs text-slate-500">Draft</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-slate-800">{{ $totalKirim }}</p>
                <p class="text-xs text-slate-500">Terkirim</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 px-4 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-slate-800">{{ $totalTerima }}</p>
                <p class="text-xs text-slate-500">Diterima</p>
            </div>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="card">
        <div class="p-4">
            <form method="GET" action="{{ route('surat-keluar.index') }}"
                  class="flex flex-wrap items-center gap-3">

                {{-- Search --}}
                <div class="relative flex-1 min-w-52">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nomor surat, perihal, tujuan..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white form-input transition-all">
                </div>

                {{-- Status --}}
                <select name="status"
                        class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input min-w-36">
                    <option value="">Semua Status</option>
                    <option value="draft"    {{ request('status') == 'draft'    ? 'selected' : '' }}>Draft</option>
                    <option value="terkirim" {{ request('status') == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                </select>

                {{-- Sifat --}}
                <select name="sifat"
                        class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input min-w-36">
                    <option value="">Semua Sifat</option>
                    <option value="biasa"         {{ request('sifat') == 'biasa'         ? 'selected' : '' }}>Biasa</option>
                    <option value="penting"       {{ request('sifat') == 'penting'       ? 'selected' : '' }}>Penting</option>
                    <option value="rahasia"       {{ request('sifat') == 'rahasia'       ? 'selected' : '' }}>Rahasia</option>
                    <option value="sangat_rahasia"{{ request('sifat') == 'sangat_rahasia'? 'selected' : '' }}>Sangat Rahasia</option>
                </select>

                {{-- Tanggal --}}
                <div class="flex items-center gap-2">
                    <input type="date" name="tanggal_dari"
                           value="{{ request('tanggal_dari') }}"
                           title="Dari tanggal"
                           class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <span class="text-slate-400 text-sm shrink-0">s/d</span>
                    <input type="date" name="tanggal_sampai"
                           value="{{ request('tanggal_sampai') }}"
                           title="Sampai tanggal"
                           class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                </div>

                {{-- Tombol --}}
                <button type="submit"
                        class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter
                </button>

                @if(request()->hasAny(['search', 'status', 'sifat', 'tanggal_dari', 'tanggal_sampai']))
                <a href="{{ route('surat-keluar.index') }}"
                   class="flex items-center gap-1.5 text-slate-500 hover:text-slate-700 px-3 py-2.5 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reset
                </a>
                @endif

            </form>
        </div>

        {{-- Active filters badge --}}
        @if(request()->hasAny(['search', 'status', 'sifat', 'tanggal_dari', 'tanggal_sampai']))
        <div class="px-4 pb-3 flex flex-wrap items-center gap-2">
            <span class="text-xs text-slate-400 font-medium">Filter aktif:</span>
            @if(request('search'))
            <span class="inline-flex items-center gap-1 text-xs bg-primary-50 text-primary-700 border border-primary-200 px-2.5 py-1 rounded-full font-medium">
                Kata kunci: "{{ request('search') }}"
            </span>
            @endif
            @if(request('status'))
            <span class="inline-flex items-center gap-1 text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full font-medium capitalize">
                Status: {{ request('status') }}
            </span>
            @endif
            @if(request('sifat'))
            <span class="inline-flex items-center gap-1 text-xs bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full font-medium capitalize">
                Sifat: {{ str_replace('_', ' ', request('sifat')) }}
            </span>
            @endif
            @if(request('tanggal_dari') || request('tanggal_sampai'))
            <span class="inline-flex items-center gap-1 text-xs bg-slate-100 text-slate-600 border border-slate-200 px-2.5 py-1 rounded-full font-medium">
                Periode: {{ request('tanggal_dari') ?? '...' }} — {{ request('tanggal_sampai') ?? '...' }}
            </span>
            @endif
        </div>
        @endif
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-left">
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">No. Agenda</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">No. Surat</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Perihal</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tujuan</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">Tgl. Surat</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Sifat</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($suratKeluar as $surat)
                    <tr class="table-row-hover group">

                        {{-- No Agenda --}}
                        <td class="px-4 py-4">
                            <span class="text-xs font-mono font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-1 rounded-lg whitespace-nowrap">
                                {{ $surat->no_agenda }}
                            </span>
                        </td>

                        {{-- No Surat --}}
                        <td class="px-4 py-4">
                            <span class="text-sm text-slate-600">
                                {{ $surat->no_surat ?? '<span class="italic text-slate-400">—</span>' }}
                            </span>
                        </td>

                        {{-- Perihal --}}
                        <td class="px-4 py-4">
                            <div class="max-w-xs">
                                <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-primary-700 transition-colors">
                                    {{ $surat->perihal }}
                                </p>
                                @if($surat->lampiran)
                                <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    {{ $surat->lampiran }}
                                </p>
                                @endif
                            </div>
                        </td>

                        {{-- Tujuan --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2 max-w-[180px]">
                                <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-slate-700 truncate">{{ $surat->tujuan_surat }}</span>
                            </div>
                        </td>

                        {{-- Tanggal Surat --}}
                        <td class="px-4 py-4 whitespace-nowrap">
                            <p class="text-sm text-slate-700">{{ $surat->tanggal_surat->isoFormat('D MMM Y') }}</p>
                            <p class="text-xs text-slate-400">{{ $surat->tanggal_surat->isoFormat('dddd') }}</p>
                        </td>

                        {{-- Sifat --}}
                        <td class="px-4 py-4">
                            @php
                                $sifatStyle = match($surat->sifat) {
                                    'penting'        => 'bg-orange-100 text-orange-700 ring-orange-200',
                                    'rahasia'        => 'bg-red-100 text-red-700 ring-red-200',
                                    'sangat_rahasia' => 'bg-red-200 text-red-900 ring-red-300',
                                    default          => 'bg-slate-100 text-slate-600 ring-slate-200',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full ring-1 {{ $sifatStyle }} capitalize whitespace-nowrap">
                                {{ str_replace('_', ' ', $surat->sifat) }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-4">
                            @php
                                $statusStyle = match($surat->status) {
                                    'draft'    => 'bg-slate-100 text-slate-600 ring-slate-200',
                                    'terkirim' => 'bg-blue-100 text-blue-700 ring-blue-200',
                                    'diterima' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                                    default    => 'bg-slate-100 text-slate-600 ring-slate-200',
                                };
                                $statusIcon = match($surat->status) {
                                    'draft'    => '✏️',
                                    'terkirim' => '📤',
                                    'diterima' => '✅',
                                    default    => '•',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full ring-1 {{ $statusStyle }} capitalize whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $surat->status === 'draft'    ? 'bg-slate-400' : '' }}
                                    {{ $surat->status === 'terkirim' ? 'bg-blue-500'  : '' }}
                                    {{ $surat->status === 'diterima' ? 'bg-emerald-500' : '' }}
                                "></span>
                                {{ ucfirst($surat->status) }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-1.5">

                                {{-- Detail --}}
                                <a href="{{ route('surat-keluar.show', $surat) }}"
                                   class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-primary-100 hover:text-primary-700 flex items-center justify-center text-slate-500 transition-colors"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @if(auth()->user()->isAdmin())

                                {{-- Edit --}}
                                <a href="{{ route('surat-keluar.edit', $surat) }}"
                                   class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 flex items-center justify-center text-slate-500 transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                {{-- Unduh file --}}
                                @if($surat->file_surat)
                                <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank"
                                   class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-emerald-100 hover:text-emerald-700 flex items-center justify-center text-slate-500 transition-colors"
                                   title="Unduh File">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                                @endif

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('surat-keluar.destroy', $surat) }}"
                                      x-data
                                      @submit.prevent="if(confirm('Yakin ingin menghapus surat keluar ini?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-100 hover:text-red-600 flex items-center justify-center text-slate-500 transition-colors"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>

                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-slate-600 font-semibold text-sm">Tidak ada surat keluar ditemukan</p>
                                    <p class="text-slate-400 text-xs mt-1">
                                        @if(request()->hasAny(['search', 'status', 'sifat', 'tanggal_dari', 'tanggal_sampai']))
                                            Coba ubah atau <a href="{{ route('surat-keluar.index') }}" class="text-primary-600 hover:underline font-medium">reset filter</a>
                                        @else
                                            Belum ada data surat keluar yang tersimpan
                                        @endif
                                    </p>
                                </div>
                                @if(auth()->user()->isAdmin() && !request()->hasAny(['search', 'status', 'sifat']))
                                <a href="{{ route('surat-keluar.create') }}"
                                   class="flex items-center gap-2 mt-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Surat Keluar Pertama
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer: info + pagination --}}
        @if($suratKeluar->total() > 0)
        <div class="px-6 py-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
            <p class="text-sm text-slate-500">
                Menampilkan
                <span class="font-semibold text-slate-700">{{ $suratKeluar->firstItem() }}–{{ $suratKeluar->lastItem() }}</span>
                dari
                <span class="font-semibold text-slate-700">{{ $suratKeluar->total() }}</span>
                data
            </p>
            @if($suratKeluar->hasPages())
            {{ $suratKeluar->links() }}
            @endif
        </div>
        @endif
    </div>

</div>
@endsection
