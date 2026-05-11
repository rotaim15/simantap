@extends('layouts.app')

@section('title', 'Surat Masuk')
@section('page-title', 'Surat Masuk')

@section('breadcrumb')
<span>Beranda</span> / <span class="text-slate-600">Surat Masuk</span>
@endsection

@section('content')
<div class="space-y-5" x-data="{ showFilter: false }">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Surat Masuk</h2>
            <p class="text-sm text-slate-500">Kelola seluruh surat masuk instansi</p>
        </div>
        <a href="{{ route('surat-masuk.create') }}"
            class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Surat Masuk
        </a>
    </div>

    {{-- Filters --}}
    <div class="card">
        <div class="p-4 flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('surat-masuk.index') }}"
                class="flex flex-wrap items-center gap-3 flex-1">
                <div class="relative flex-1 min-w-52">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nomor surat, perihal, asal..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white form-input transition-all">
                </div>
                <select name="status"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ request('status')=='diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status')=='ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <select name="sifat"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Sifat</option>
                    <option value="biasa" {{ request('sifat')=='biasa' ? 'selected' : '' }}>Biasa</option>
                    <option value="penting" {{ request('sifat')=='penting' ? 'selected' : '' }}>Penting</option>
                    <option value="rahasia" {{ request('sifat')=='rahasia' ? 'selected' : '' }}>Rahasia</option>
                </select>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'sifat', 'tanggal_dari']))
                <a href="{{ route('surat-masuk.index') }}"
                    class="text-slate-500 hover:text-slate-700 px-3 py-2.5 text-sm transition-colors">
                    Reset
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">No. Agenda
                        </th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">No. Surat</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Perihal</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Asal Surat
                        </th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl. Terima
                        </th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Sifat</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($suratMasuk as $surat)
                    <tr class="table-row-hover">
                        <td class="px-4 py-4">
                            <span
                                class="text-xs font-mono font-semibold text-slate-600 bg-slate-100 px-2 py-1 rounded">{{
                                $surat->no_agenda }}</span>
                        </td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $surat->no_surat }}</td>
                        <td class="px-4 py-4">
                            <p class="text-sm font-semibold text-slate-800 max-w-xs truncate">{{ $surat->perihal }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $surat->asal_surat }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600 whitespace-nowrap">{{
                            $surat->tanggal_terima->isoFormat('D MMM Y') }}</td>
                        <td class="px-4 py-4">
                            @php
                            $sifatColor = match($surat->sifat) {
                            'penting' => 'bg-orange-100 text-orange-700',
                            'rahasia' => 'bg-red-100 text-red-700',
                            'sangat_rahasia' => 'bg-red-200 text-red-900',
                            default => 'bg-slate-100 text-slate-600'
                            };
                            @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $sifatColor }} capitalize">
                                {{ str_replace('_', ' ', $surat->sifat) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            @php
                            $statusColor = match($surat->status) {
                            'pending' => 'badge-pending',
                            'diproses' => 'badge-diproses',
                            'selesai' => 'badge-selesai',
                            'ditolak' => 'badge-ditolak',
                            default => 'bg-slate-100 text-slate-600'
                            };
                            @endphp
                            <span
                                class="text-xs font-semibold px-2.5 py-1 rounded-full ring-1 capitalize {{ $statusColor }}">
                                {{ $surat->status }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('surat-masuk.show', $surat) }}"
                                    class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-primary-100 hover:text-primary-700 flex items-center justify-center text-slate-600 transition-colors"
                                    title="Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('disposisi.create', ['surat_masuk_id' => $surat->id]) }}"
                                    class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 hover:text-amber-700 flex items-center justify-center transition-colors"
                                    title="Buat Disposisi">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('surat-masuk.edit', $surat) }}"
                                    class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 flex items-center justify-center text-slate-600 transition-colors"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('surat-masuk.destroy', $surat) }}" x-data
                                    @submit.prevent="if(confirm('Hapus surat masuk ini?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-100 hover:text-red-700 flex items-center justify-center text-slate-600 transition-colors"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-sm font-medium">Tidak ada surat masuk ditemukan</p>
                                <a href="{{ route('surat-masuk.create') }}"
                                    class="text-primary-600 text-sm hover:underline">+ Tambah Surat Masuk</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($suratMasuk->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $suratMasuk->links() }}
        </div>
        @endif
    </div>

</div>
@endsection