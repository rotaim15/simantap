@extends('layouts.app')

@section('title', 'Daftar Disposisi')
@section('page-title', 'Daftar Disposisi')

@section('breadcrumb')
<span>Beranda</span> / <span class="text-slate-600">Disposisi</span>
@endsection

@section('content')
<div class="space-y-5" x-data="{ showFilter: false }">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Daftar Disposisi</h2>
            <p class="text-sm text-slate-500">Kelola seluruh disposisi surat masuk</p>
        </div>
        <a href="{{ route('disposisi.create') }}"
            class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Disposisi Baru
        </a>
    </div>

    {{-- Filters --}}
    <div class="card">
        <div class="p-4 flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('disposisi.index') }}"
                class="flex flex-wrap items-center gap-3 flex-1">
                <div class="relative flex-1 min-w-52">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kode disposisi, instruksi, perihal surat..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white form-input transition-all">
                </div>
                <select name="status"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <select name="prioritas"
                    class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm form-input">
                    <option value="">Semua Prioritas</option>
                    <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="normal" {{ request('prioritas') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="segera" {{ request('prioritas') == 'segera' ? 'selected' : '' }}>Segera</option>
                </select>
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'prioritas']))
                <a href="{{ route('disposisi.index') }}"
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
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider w-12">No</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode Disposisi</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Perihal Surat</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Dari</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl. Disposisi</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Batas Waktu</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Prioritas</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Penerima</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($disposisi as $index => $item)
                    <tr class="table-row-hover">
                        <td class="px-4 py-4 text-sm text-slate-500 text-center">{{ $disposisi->firstItem() + $index }}</td>
                        <td class="px-4 py-4">
                            <span class="text-xs font-mono font-semibold text-primary-700 bg-primary-50 px-2 py-1 rounded">
                                {{ $item->kode_disposisi }}
                            </span>
                            @if($item->isOverdue() && $item->status != 'selesai')
                                <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-700">
                                    Overdue
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm font-semibold text-slate-800 max-w-xs truncate" title="{{ $item->suratMasuk->perihal ?? '-' }}">
                                {{ Str::limit($item->suratMasuk->perihal ?? '-', 45) }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $item->suratMasuk->no_surat ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-4 text-sm text-slate-600">{{ $item->dariUser->name ?? '-' }}</td>
                        <td class="px-4 py-4 text-sm text-slate-600 whitespace-nowrap">
                            {{ $item->tanggal_disposisi ? $item->tanggal_disposisi->isoFormat('D MMM Y') : '-' }}
                        </td>
                        <td class="px-4 py-4">
                            @if($item->batas_waktu)
                                <span class="text-sm whitespace-nowrap {{ $item->isOverdue() && $item->status != 'selesai' ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                                    {{ $item->batas_waktu->isoFormat('D MMM Y') }}
                                </span>
                            @else
                                <span class="text-slate-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @php
                                $prioritasStyles = [
                                    'rendah' => 'bg-slate-100 text-slate-600',
                                    'normal' => 'bg-blue-100 text-blue-700',
                                    'tinggi' => 'bg-orange-100 text-orange-700',
                                    'segera' => 'bg-red-100 text-red-700',
                                ];
                                $style = $prioritasStyles[$item->prioritas] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $style }} capitalize">
                                {{ $item->prioritas }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($item->penerima as $penerima)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-slate-100 text-slate-600"
                                          title="Status: {{ $penerima->pivot->status ?? 'belum_dibaca' }}">
                                        {{ Str::limit($penerima->name, 12) }}
                                        @if(($penerima->pivot->status ?? '') == 'selesai')
                                            <svg class="w-3 h-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @php
                                $statusStyles = [
                                    'aktif' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    'dibatalkan' => 'bg-red-100 text-red-700',
                                ];
                                $statusStyle = $statusStyles[$item->status] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full ring-1 capitalize {{ $statusStyle }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('disposisi.show', $item) }}"
                                    class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-primary-100 hover:text-primary-700 flex items-center justify-center text-slate-600 transition-colors"
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
                                    class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-amber-100 hover:text-amber-700 flex items-center justify-center text-slate-600 transition-colors"
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
                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-100 hover:text-red-700 flex items-center justify-center text-slate-600 transition-colors"
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
                        <td colspan="10" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-sm font-medium">Tidak ada disposisi ditemukan</p>
                                <a href="{{ route('disposisi.create') }}"
                                    class="text-primary-600 text-sm hover:underline">+ Buat Disposisi Baru</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($disposisi->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $disposisi->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
