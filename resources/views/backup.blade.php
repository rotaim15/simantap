<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manual Backup Laravel 12</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-100 p-10 font-sans">

    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="p-6 bg-slate-800 flex justify-between items-center">
            <h1 class="text-white text-xl font-bold">Database Manual Backup</h1>
            <form action="{{ route('backup.run') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-6 rounded-lg transition-all active:scale-95">
                    Klik Untuk Backup ⚡
                </button>
            </form>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                {{ session('error') }}
            </div>
            @endif

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-500 uppercase text-xs border-b">
                        <th class="py-3 px-2">Nama File</th>
                        <th class="py-3 px-2">Ukuran</th>
                        <th class="py-3 px-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @forelse($files as $file)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="py-4 px-2 font-mono text-sm">{{ basename($file) }}</td>
                        <td class="py-4 px-2 text-sm">{{ round(Storage::size($file) / 1024, 2) }} KB</td>
                        <td class="py-4 px-2 text-right">
                            <a href="{{ route('backup.download', basename($file)) }}"
                                class="text-blue-500 hover:underline font-semibold">
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-10 text-center text-slate-400 italic">Belum ada file backup.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>