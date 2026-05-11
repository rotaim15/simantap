<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ManualBackupController extends Controller
{
    public function index()
    {
        // Ambil daftar file dari folder storage/app/backups
        $files = Storage::disk('local')->files('backups');
        return view('backup', compact('files'));
    }

    // public function create()
    // {
    //     $filename = "backup-" . Carbon::now()->format('Y-m-d_H-i-s') . ".sql";
    //     $storagePath = storage_path('app/backups');

    //     // Pastikan folder backups ada
    //     if (!file_exists($storagePath)) {
    //         mkdir($storagePath, 0755, true);
    //     }

    //     $path = $storagePath . '/' . $filename;

    //     // Ambil konfigurasi dari .env secara otomatis
    //     $host = config('database.connections.mysql.host');
    //     $username = config('database.connections.mysql.username');
    //     $password = config('database.connections.mysql.password');
    //     $database = config('database.connections.mysql.database');

    //     // Command mysqldump
    //     // Pastikan bin mysqldump ada di PATH sistem Anda
    //     $command = sprintf(
    //         'mysqldump --user=%s --password=%s --host=%s %s > %s',
    //         escapeshellarg($username),
    //         escapeshellarg($password),
    //         escapeshellarg($host),
    //         escapeshellarg($database),
    //         escapeshellarg($path)
    //     );

    //     $output = NULL;
    //     $resultCode = NULL;

    //     exec($command, $output, $resultCode);

    //     if ($resultCode === 0) {
    //         return back()->with('success', "Database berhasil di-backup: $filename");
    //     } else {
    //         return back()->with('error', "Terjadi kesalahan saat menjalankan mysqldump. Kode: $resultCode");
    //     }
    // }

    public function create()
{
    $filename = "backup-" . now()->format('Y-m-d_H-i-s') . ".sql";
    $storagePath = storage_path('app/backups');

    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    $path = $storagePath . '/' . $filename;

    // Ambil kredensial dari config Laravel
    $host = config('database.connections.mysql.host'); // biasanya 127.0.0.1
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');
    $database = config('database.connections.mysql.database');

    // Di Linux, penggunaan --password tanpa spasi sangat krusial
    $passwordPart = !empty($password) ? "-p" . escapeshellarg($password) : "";

    $command = sprintf(
        'mysqldump -h %s -u %s %s %s > %s',
        escapeshellarg($host),
        escapeshellarg($username),
        $passwordPart,
        escapeshellarg($database),
        escapeshellarg($path)
    );

    $output = [];
    $resultCode = null;

    // Jalankan command
    exec($command . ' 2>&1', $output, $resultCode);

    if ($resultCode === 0) {
        return back()->with('success', "Backup tersimpan di Linux Server: $filename");
    } else {
        $error = implode(' ', $output);
        return back()->with('error', "Gagal (Kode $resultCode): $error");
    }
}

    public function download($file)
    {
        return Storage::disk('local')->download('backups/' . $file);
    }
}
