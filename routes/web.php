<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('dashboard.index');
// });
Route::get('/lokasis', function () {
    return view('lokasi.lokasi');
})->name('lokasis');


Route::middleware('auth')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('layouts.dashboard');
    // })->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::resource('agenda', App\Http\Controllers\AgendaController::class);
    Route::get('/peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
    Route::post('/peserta', [PesertaController::class, 'store'])->name('peserta.store');

    Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
    Route::get('/api/peserta', function () {
        return \App\Models\Peserta::select('id', 'nama')->get();
    });
    Route::resource('lokasi', LokasiController::class);
    Route::resource('agendas', AgendaController::class)->except(['create', 'edit', 'show']);
});

Route::get('/manual-backup', [App\Http\Controllers\ManualBackupController::class, 'index'])->name('backup.index');
Route::post('/manual-backup/run', [App\Http\Controllers\ManualBackupController::class, 'create'])->name('backup.run');
Route::get('/manual-backup/download/{file}', [App\Http\Controllers\ManualBackupController::class, 'download'])->name('backup.download');



// Route::get('/agendas', [AgendaController::class, 'index'])->name('agenda.index');

// Route::post('/agendas', [AgendaController::class, 'store']);
// Route::put('/agendas/{id}', [AgendaController::class, 'update']);
// Route::delete('/agendas/{id}', [AgendaController::class, 'destroy']);



// data untuk SPA
Route::get('/agendas-data', [AgendaController::class, 'data']);
Route::get('/pesertas-data', [PesertaController::class, 'data']);
Route::get('/lokasis-data', [LokasiController::class, 'apiIndex']);

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [App\Http\Controllers\DashboarController::class, 'index'])->name('dashboard');

    // Surat Masuk
    Route::resource('surat-masuk', SuratMasukController::class)->names([
        'index' => 'surat-masuk.index',
        'create' => 'surat-masuk.create',
        'store' => 'surat-masuk.store',
        'show' => 'surat-masuk.show',
        'edit' => 'surat-masuk.edit',
        'update' => 'surat-masuk.update',
        'destroy' => 'surat-masuk.destroy',
    ]);

    // Surat Keluar
    Route::resource('surat-keluar', SuratKeluarController::class)->names([
        'index' => 'surat-keluar.index',
        'create' => 'surat-keluar.create',
        'store' => 'surat-keluar.store',
        'show' => 'surat-keluar.show',
        'edit' => 'surat-keluar.edit',
        'update' => 'surat-keluar.update',
        'destroy' => 'surat-keluar.destroy',
    ]);

    // Disposisi
    Route::get('/disposisi/inbox', [DisposisiController::class, 'inbox'])->name('disposisi.inbox');
    Route::post('/disposisi/{disposisi}/tanggapi', [DisposisiController::class, 'tanggapi'])->name('disposisi.tanggapi');
    Route::resource('disposisi', DisposisiController::class);


    // Users (admin only)
});
// Route::resource('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index')->middleware('admin');


require __DIR__ . '/auth.php';

Route::get('/disposisi/inbox', [DisposisiController::class, 'inbox'])->name('disposisi.inbox');
Route::post('/disposisi/{disposisi}/tanggapi', [DisposisiController::class, 'tanggapi'])->name('disposisi.tanggapi');
Route::resource('disposisi', DisposisiController::class);

// Users (admin only)
Route::resource('users', UserController::class)->middleware('can:admin');

Route::get('/agenda', [App\Http\Controllers\AgendaController::class, 'index'])
    ->name('agenda.index');
Route::get('/', [App\Http\Controllers\AgendasuratController::class, 'index'])
    ->name('agenda-surat.index');
