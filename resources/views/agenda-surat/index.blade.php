<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agenda Surat — SIMANTAP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{--
    <link rel="stylesheet" href="{{ asset('css/app-64QsGoLB.css') }}"> --}}

    <style>
        @media print {
            @page {
                size: 330mm 210mm landscape;
                /* F4 Landscape */
                margin: 10mm;
            }

            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print-area th {
                background-color: #0e7490 !important;

            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 11px;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 6px 5px;
                vertical-align: middle;
            }

            thead th {
                background-color: #0e7490 !important;
                color: white !important;
            }

            tr.bg-emerald-600 {
                background-color: #10b981 !important;
                color: white !important;
            }
        }
    </style>
</head>

<body class="h-full bg-slate-50 font-sans antialiased">

    <div class="min-h-screen bg-slate-100 p-3 md:p-6" x-data="{
        search: '{{ request('search') }}',
        debouncedSearch: '{{ request('search') }}',
        debounceTimeout: null,

        init() {
            this.$watch('search', (value) => {
                clearTimeout(this.debounceTimeout);
                this.debounceTimeout = setTimeout(() => {
                    this.debouncedSearch = value;
                }, 350);
            });
        },

        filterRow(item) {
            if (!this.debouncedSearch) return true;
            const term = this.debouncedSearch.toLowerCase().trim();
            return (
                (item.no_agenda?.toLowerCase() || '').includes(term) ||
                (item.instansi?.toLowerCase() || '').includes(term) ||
                (item.perihal?.toLowerCase() || '').includes(term) ||
                (item.jenis?.toLowerCase() || '').includes(term)
            );
        }
     }">

        {{-- HEADER & FILTER --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-5">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 text-center uppercase">
                AGENDA activities civil service police of semarang city
            </h1>
            <p class="text-center text-slate-500 mt-2">Agenda Surat Masuk & Surat Keluar</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4 mb-5">
            <form method="GET" action="{{ route('agenda-surat.index') }}">
                <div class="flex flex-col lg:flex-row gap-4 lg:items-end lg:justify-between">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Pencarian</label>
                            <div class="relative">
                                <input type="text" x-model="search" name="search"
                                    placeholder="Cari no agenda, instansi, perihal..."
                                    class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring-sky-500 pl-10">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">🔎</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full rounded-xl border-slate-300 focus:border-sky-500 focus:ring-sky-500">
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-2 rounded-xl text-sm font-medium">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('agenda-surat.index') }}"
                            class="bg-slate-500 hover:bg-slate-600 text-white px-6 py-2 rounded-xl text-sm font-medium">
                            Reset
                        </a>
                        <button type="button" onclick="window.print()"
                            class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-2 rounded-xl text-sm font-medium">
                            🖨 Print
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- PRINT AREA --}}
        <div class="print-area bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-sky-700 text-white">
                        <tr class="uppercase">
                            <th class="px-3 py-3 border w-16">No</th>
                            <th class="px-3 py-3 border">Origin Of the Letter</th>
                            <th class="px-3 py-3 border">Regarding</th>
                            <th class="px-3 py-3 border">day date</th>
                            <th class="px-3 py-3 border">time</th>
                            <th class="px-3 py-3 border">place</th>
                            <th class="px-3 py-3 border">Disposition</th>
                            <th class="px-3 py-3 border">Sifat</th>
                            <th class="px-3 py-3 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $nomor = 1; @endphp

                        @forelse($agenda as $hari => $items)
                        {{-- Header Hari --}}
                        <tr class="bg-emerald-600 text-white">
                            <td colspan="9" class="text-xs px-3 py-1 font-bold uppercase tracking-wide border">
                                {{ $hari }}
                                <span class="ml-3 text-emerald-100 text-xs">({{ count($items) }} Agenda)</span>
                            </td>
                        </tr>

                        {{-- Data Agenda --}}
                        @foreach($items as $item)
                        <tr class="hover:bg-slate-50 transition" x-show="filterRow({
                                    no_agenda: '{{ addslashes($item->no_agenda ?? '') }}',
                                    instansi: '{{ addslashes($item->instansi ?? '') }}',
                                    perihal: '{{ addslashes($item->perihal ?? '') }}',
                                    jenis: '{{ $item->jenis ?? '' }}'
                                })">
                            <td class="border px-3 py-2 text-center">{{ $nomor++ }}</td>
                            <td class="border px-3 py-2 whitespace-nowrap">{{ $item->instansi }}</td>

                            <td class="border px-3 py-2">{{ $item->perihal }}</td>
                            <td class="border px-3 py-2">{{
                                \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('l,d M Y') }}</td>
                            <td class="border px-3 py-2 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->waktumulai)->translatedFormat('H:i') }} - {{
                                __('selesai') }}
                            </td>
                            <td class="border px-3 py-2">
                                {{ $item->lokasi }}

                            </td>
                            <td class="border px-3 py-2">
                                @if($item->disposisikan_display)
                                <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $item->disposisikan_display }}
                                </span>
                                @else
                                -
                                @endif
                            </td>
                            <td class="border px-3 py-2">
                                <span class="px-2 py-1 rounded-lg text-xs font-semibold @switch($item->sifat)
                                        @case('penting') bg-yellow-100 text-yellow-700 @break
                                        @case('rahasia') bg-red-100 text-red-700 @break
                                        @case('sangat_rahasia') bg-purple-100 text-purple-700 @break
                                        @default bg-slate-100 text-slate-700 @endswitch">
                                    {{ strtoupper($item->sifat ?? '-') }}
                                </span>
                            </td>
                            <td class="border px-3 py-2">
                                <span class="px-2 py-1 rounded-lg text-xs font-semibold
                                        @if(in_array($item->status, ['selesai','diterima'])) bg-emerald-100 text-emerald-700
                                        @elseif(in_array($item->status, ['pending','draft'])) bg-yellow-100 text-yellow-700
                                        @else bg-slate-100 text-slate-700 @endif">
                                    {{ strtoupper($item->status ?? '-') }}
                                </span>
                            </td>
                            {{-- <td class="border px-3 py-2">
                                <span
                                    class="px-2 py-1 rounded-lg text-xs font-semibold
                                        {{ $item->jenis == 'Surat Masuk' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                                    {{ $item->jenis }}
                                </span>
                            </td> --}}
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-10 text-slate-500">
                                Data agenda tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('js/app-B_Do3-c-.js') }}"></script> --}}

</body>

</html>