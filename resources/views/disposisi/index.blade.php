@extends('layouts.app')

@section('title', 'Semua Disposisi')
@section('page-title', 'Disposisi')

@section('breadcrumb')
<span>Beranda</span> / <span class="text-slate-600">Disposisi</span>
@endsection

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Semua Disposisi</h2>
            <p class="text-sm text-slate-500">Kelola disposisi surat masuk dan surat keluar</p>
        </div>
        @if(auth()->user()->isAdmin() || auth()->user()->isPimpinan())
        <div class="flex items-center gap-2" x-data="{ open: false }">
            <div class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Disposisi
                    <svg class="w-3.5 h-3.5" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-50">
                    <a href="{{ route('disposisi.create', ['jenis' => 'masuk']) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold">Surat Masuk</p>
                            <p class="text-xs text-slate-400">Disposisi surat diterima</p>
                        </div>
                    </a>
                    <a href="{{ route('disposisi.create', ['jenis' => 'keluar']) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold">Surat Keluar</p>
                            <p class="text-xs text-slate-400">Disposisi surat dikirim</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Filter --}}
    <div class="card">
        <div class="p-4">
            <form method="GET" action="{{ route('disposisi.index') }}" class="flex flex-wrap items-center gap-3">
                {{-- Search --}}
                <div class="relative flex-1 min-w-52">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kode, instruksi, perihal..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input transition-all">
                </div>
                {{-- Jenis --}}
                <select name="jenis"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Jenis</option>
                    <option value="masuk" {{ request('jenis')=='masuk' ? 'selected' : '' }}>Surat Masuk</option>
                    <option value="keluar" {{ request('jenis')=='keluar' ? 'selected' : '' }}>Surat Keluar</option>
                </select>
                {{-- Status --}}
                <select name="status"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status')=='aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status')=='dibatalkan' ? 'selected' : '' }}>Dibatalkan
                    </option>
                </select>
                {{-- Prioritas --}}
                <select name="prioritas"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Prioritas</option>
                    <option value="segera" {{ request('prioritas')=='segera' ? 'selected' : '' }}>Segera</option>
                    <option value="tinggi" {{ request('prioritas')=='tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="normal" {{ request('prioritas')=='normal' ? 'selected' : '' }}>Normal</option>
                    <option value="rendah" {{ request('prioritas')=='rendah' ? 'selected' : '' }}>Rendah</option>
                </select>
                <button type="submit"
                    class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search','status','prioritas','jenis']))
                <a href="{{ route('disposisi.index') }}"
                    class="text-slate-500 hover:text-slate-700 text-sm px-3 py-2.5">Reset</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-left">
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Surat</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Dari</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Penerima</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Prioritas</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl.</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($disposisi as $item)
                    @php
                    $jenis = $item->getJenisSurat();
                    $perihal = $item->getPerihalSurat();
                    $noAgenda = $item->getNoAgendaSurat();
                    $isOverdue = $item->isOverdue();
                    @endphp
                    <tr class="table-row-hover group {{ $isOverdue ? 'bg-red-50/30' : '' }}">

                        {{-- Kode --}}
                        <td class="px-4 py-4">
                            <span
                                class="text-xs font-mono font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-1 rounded-lg whitespace-nowrap">
                                {{ $item->kode_disposisi }}
                            </span>
                            @if($isOverdue)
                            <p class="text-[10px] text-red-500 font-semibold mt-1">⚠ Terlambat</p>
                            @endif
                        </td>

                        {{-- Jenis --}}
                        <td class="px-4 py-4">
                            @if($jenis === 'masuk')
                            <span
                                class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-full bg-blue-100 text-blue-700 whitespace-nowrap">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                Masuk
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 whitespace-nowrap">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Keluar
                            </span>
                            @endif
                        </td>

                        {{-- Surat --}}
                        <td class="px-4 py-4">
                            <div class="max-w-[220px]">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $perihal }}</p>
                                <p class="text-xs text-slate-400 mt-0.5 font-mono">{{ $noAgenda }}</p>
                            </div>
                        </td>

                        {{-- Dari --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ $item->dariUser->getAvatarUrl() }}"
                                    class="w-7 h-7 rounded-lg object-cover shrink-0" alt="">
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-700 truncate max-w-[100px]">{{
                                        $item->dariUser->name }}</p>
                                    <p class="text-[10px] text-slate-400 capitalize">{{ $item->dariUser->role }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Penerima --}}
                        <td class="px-4 py-4">
                            <div class="flex -space-x-1.5">
                                @foreach($item->penerima->take(3) as $p)
                                <img src="{{ $p->getAvatarUrl() }}"
                                    class="w-7 h-7 rounded-lg object-cover ring-2 ring-white" title="{{ $p->name }}"
                                    alt="{{ $p->name }}">
                                @endforeach
                                @if($item->penerima->count() > 3)
                                <div
                                    class="w-7 h-7 rounded-lg bg-slate-200 ring-2 ring-white flex items-center justify-center">
                                    <span class="text-[9px] font-bold text-slate-600">+{{ $item->penerima->count() - 3
                                        }}</span>
                                </div>
                                @endif
                            </div>
                        </td>

                        {{-- Prioritas --}}
                        <td class="px-4 py-4">
                            @php
                            $priStyle = match($item->prioritas) {
                            'segera' => 'bg-red-100 text-red-700 ring-red-200',
                            'tinggi' => 'bg-orange-100 text-orange-700 ring-orange-200',
                            'rendah' => 'bg-slate-100 text-slate-500 ring-slate-200',
                            default => 'bg-blue-100 text-blue-700 ring-blue-200',
                            };
                            @endphp
                            <span
                                class="text-[10px] font-bold px-2 py-0.5 rounded-full ring-1 capitalize {{ $priStyle }}">
                                {{ $item->prioritas }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-4">
                            @php
                            $statusStyle = match($item->status) {
                            'selesai' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                            'dibatalkan' => 'bg-red-100 text-red-700 ring-red-200',
                            default => 'bg-amber-100 text-amber-700 ring-amber-200',
                            };
                            @endphp
                            <span
                                class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-full ring-1 capitalize {{ $statusStyle }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $item->status === 'aktif'      ? 'bg-amber-500'  : '' }}
                                    {{ $item->status === 'selesai'    ? 'bg-emerald-500': '' }}
                                    {{ $item->status === 'dibatalkan' ? 'bg-red-500'    : '' }}
                                "></span>
                                {{ $item->status }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-4 py-4 whitespace-nowrap">
                            <p class="text-xs text-slate-600">{{ $item->tanggal_disposisi->isoFormat('D MMM Y') }}</p>
                            @if($item->batas_waktu)
                            <p
                                class="text-[10px] {{ $isOverdue ? 'text-red-500 font-semibold' : 'text-slate-400' }} mt-0.5">
                                Batas: {{ $item->batas_waktu->isoFormat('D MMM Y') }}
                            </p>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('disposisi.show', $item) }}"
                                    class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-amber-100 hover:text-amber-700 flex items-center justify-center text-slate-500 transition-colors"
                                    title="Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @can('update', $item)
                                <a href="{{ route('disposisi.edit', $item) }}"
                                    class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 flex items-center justify-center text-slate-500 transition-colors"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                @endcan
                                @can('delete', $item)
                                <form method="POST" action="{{ route('disposisi.destroy', $item) }}" x-data
                                    @submit.prevent="if(confirm('Hapus disposisi {{ $item->kode_disposisi }}?')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-100 hover:text-red-600 flex items-center justify-center text-slate-500 transition-colors"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-semibold text-sm">Tidak ada disposisi ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($disposisi->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-500">
                Menampilkan <span class="font-semibold text-slate-700">{{ $disposisi->firstItem() }}–{{
                    $disposisi->lastItem() }}</span>
                dari <span class="font-semibold text-slate-700">{{ $disposisi->total() }}</span> data
            </p>
            {{ $disposisi->links() }}
        </div>
        @endif
    </div>

</div>
@endsection