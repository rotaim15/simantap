<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Surat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: Inter, sans-serif;
            background: #f8fafc;
        }

        [x-cloak] {
            display: none !important;
        }

        @media print {

            .no-print,
            .toolbar {
                display: none !important;
            }

            body {
                background: white;
            }
        }
    </style>
</head>

<body class="p-4 md:p-6">

    <div x-data="agendaApp()" x-cloak class="space-y-5">

        {{-- TOOLBAR --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 toolbar">
            <div class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[250px]">
                    <label class="block text-sm font-medium text-slate-600 mb-1">Pencarian</label>
                    <input type="text" x-model="query" placeholder="Cari agenda..."
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Mulai</label>
                    <input type="date" x-model="tanggalMulai" class="rounded-xl border border-slate-300 px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Selesai</label>
                    <input type="date" x-model="tanggalSelesai" class="rounded-xl border border-slate-300 px-4 py-3">
                </div>
                <div class="flex gap-2 flex-wrap">
                    <button @click="resetFilter()"
                        class="px-5 py-3 rounded-xl bg-slate-200 hover:bg-slate-300 font-semibold">Reset</button>
                    <button onclick="window.print()"
                        class="px-5 py-3 rounded-xl bg-slate-800 text-white font-semibold">Print</button>
                    <a href="{{ url('agenda.export.excel') }}"
                        class="px-5 py-3 rounded-xl bg-emerald-600 text-white font-semibold">Excel</a>
                    <a href="{{ url('agenda.export.pdf') }}"
                        class="px-5 py-3 rounded-xl bg-red-600 text-white font-semibold">PDF</a>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-2xl border p-5">
                <p class="text-sm text-slate-500">Total</p>
                <h1 class="text-3xl font-bold" x-text="stats.total"></h1>
            </div>
            <div class="bg-white rounded-2xl border p-5">
                <p class="text-sm text-slate-500">Masuk</p>
                <h1 class="text-3xl font-bold text-blue-600" x-text="stats.masuk"></h1>
            </div>
            <div class="bg-white rounded-2xl border p-5">
                <p class="text-sm text-slate-500">Keluar</p>
                <h1 class="text-3xl font-bold text-emerald-600" x-text="stats.keluar"></h1>
            </div>
            <div class="bg-white rounded-2xl border p-5">
                <p class="text-sm text-slate-500">Pending</p>
                <h1 class="text-3xl font-bold text-amber-500" x-text="stats.pending"></h1>
            </div>
            <div class="bg-white rounded-2xl border p-5">
                <p class="text-sm text-slate-500">Selesai</p>
                <h1 class="text-3xl font-bold text-green-600" x-text="stats.selesai"></h1>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1100px]">
                    <thead class="bg-teal-700 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">No Agenda</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Jenis</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Instansi</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Perihal</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Waktu</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Sifat</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        {{-- LOOP PER TANGGAL --}}
                        <template x-for="(rows, tanggal) in grouped" :key="tanggal">
                            {{-- BARIS HEADER GROUP --}}
                            <tr class="bg-slate-100 border-y border-slate-300">
                                <td colspan="9" class="px-4 py-3 font-bold text-slate-700">
                                    <div class="flex items-center gap-2">
                                        <span x-text="formatHari(tanggal)"></span>
                                        <span>-</span>
                                        <span x-text="formatTanggal(tanggal)"></span>
                                    </div>
                                </td>
                            </tr>
                            {{-- LOOP ITEM DALAM GROUP --}}
                            <template x-for="(row, index) in rows" :key="row.id">
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm" x-text="index + 1"></td>
                                    <td class="px-4 py-3 text-sm font-medium" x-text="row.no_agenda || '-'"></td>
                                    <td class="px-4 py-3 text-sm">
                                        <span x-show="row.jenis == 'masuk'"
                                            class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs">Masuk</span>
                                        <span x-show="row.jenis == 'keluar'"
                                            class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Keluar</span>
                                        <span x-show="row.jenis != 'masuk' && row.jenis != 'keluar'"
                                            x-text="row.jenis || '-'" class="px-2 py-1 rounded bg-gray-100"></span>
                                    </td>
                                    <td class="px-4 py-3 text-sm" x-text="row.instansi || '-'"></td>
                                    <td class="px-4 py-3 text-sm" x-text="row.perihal || '-'"></td>
                                    <td class="px-4 py-3 text-sm" x-text="formatTanggal(row.tanggal)"></td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            x-text="row.waktu_mulai && row.waktu_selesai ? row.waktu_mulai + ' - ' + row.waktu_selesai : '-'"></span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 rounded text-xs bg-orange-100 text-orange-700"
                                            x-text="row.sifat || '-'"></span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 rounded text-xs"
                                            :class="{'bg-green-100 text-green-700': row.status == 'selesai', 'bg-amber-100 text-amber-700': row.status == 'pending', 'bg-slate-100 text-slate-700': !row.status || row.status != 'pending' && row.status != 'selesai'}"
                                            x-text="row.status || '-'"></span>
                                    </td>
                                </tr>
                            </template>
                        </template>

                        {{-- PESAN KOSONG --}}
                        <template x-if="filtered.length === 0">
                            <tr>
                                <td colspan="9" class="px-4 py-10 text-center text-slate-400 italic">
                                    Data tidak ditemukan...
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="p-4 text-sm text-slate-500">
                Menampilkan <span x-text="filtered.length"></span> agenda
            </div>
        </div>
    </div>

    <script>
        function agendaApp() {
            return {
                query: '',
                tanggalMulai: '',
                tanggalSelesai: '',
                allData: @json($agendaData),

                init() {
                    // Debug: lihat data di console browser
                    console.log('Data agenda:', this.allData);
                    // Jika data kosong atau tidak sesuai, bisa diisi dummy (opsional)
                    if (!this.allData || this.allData.length === 0) {
                        console.warn('Tidak ada data dari server. Gunakan data dummy untuk preview.');
                        // Hapus blok ini jika backend sudah benar
                        this.allData = [

                        ];
                    }
                },

                get filtered() {
                    if (!this.allData) return [];
                    return this.allData.filter(r => {
                        const q = this.query.toLowerCase();
                        const cocokSearch = !q ||
                            (r.no_agenda || '').toLowerCase().includes(q) ||
                            (r.instansi || '').toLowerCase().includes(q) ||
                            (r.perihal || '').toLowerCase().includes(q) ||
                            (r.sifat || '').toLowerCase().includes(q) ||
                            (r.status || '').toLowerCase().includes(q);

                        const cocokTanggalMulai = !this.tanggalMulai || r.tanggal >= this.tanggalMulai;
                        const cocokTanggalSelesai = !this.tanggalSelesai || r.tanggal <= this.tanggalSelesai;

                        return cocokSearch && cocokTanggalMulai && cocokTanggalSelesai;
                    });
                },

                get grouped() {
                    const groups = {};
                    this.filtered.forEach(r => {
                        const tgl = r.tanggal;
                        if (!groups[tgl]) groups[tgl] = [];
                        groups[tgl].push(r);
                    });
                    // Urutkan tanggal descending (opsional)
                    return Object.keys(groups).sort().reverse().reduce((obj, key) => {
                        obj[key] = groups[key];
                        return obj;
                    }, {});
                },

                get stats() {
                    const data = this.filtered;
                    return {
                        total: data.length,
                        masuk: data.filter(i => i.jenis === 'masuk').length,
                        keluar: data.filter(i => i.jenis === 'keluar').length,
                        pending: data.filter(i => i.status === 'pending').length,
                        selesai: data.filter(i => i.status === 'selesai').length,
                    };
                },

                formatTanggal(tanggal) {
                    if (!tanggal) return '';
                    try {
                        return new Date(tanggal).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });
                    } catch(e) {
                        return tanggal;
                    }
                },

                formatHari(tanggal) {
                    if (!tanggal) return '';
                    try {
                        return new Date(tanggal).toLocaleDateString('id-ID', {
                            weekday: 'long'
                        });
                    } catch(e) {
                        return '';
                    }
                },

                resetFilter() {
                    this.query = '';
                    this.tanggalMulai = '';
                    this.tanggalSelesai = '';
                }
            }
        }
    </script>
</body>

</html>