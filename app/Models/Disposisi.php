<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    protected $table = 'disposisi';
    protected $fillable = [
        'kode_disposisi',
        'jenis',
        'surat_masuk_id',
        'surat_keluar_id',
        'user_id',
        'tanggal_disposisi',
        'batas_waktu',
        'instruksi',
        'catatan',
        'prioritas',
        'status',
    ];

    protected $casts = [
        'tanggal_disposisi' => 'date',
        'batas_waktu' => 'date',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }
    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class, 'surat_keluar_id');
    }
    public function getSurat(): ?Model
    {
        return $this->suratMasuk ?? $this->suratKeluar;
    }
    public function getJenisSurat(): string
    {
        return $this->surat_masuk_id ? 'masuk' : 'keluar';
    }
    public function getPerihalSurat(): string
    {
        return $this->suratMasuk?->perihal ?? $this->suratKeluar?->perihal ?? '—';
    }
    public function getNoAgendaSurat(): string
    {
        return $this->suratMasuk?->no_agenda ?? $this->suratKeluar?->no_agenda ?? '—';
    }


    public function dariUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penerima()
    {
        return $this->belongsToMany(User::class, 'disposisi_penerima', 'disposisi_id', 'user_id')
            ->withPivot(['status', 'tanggapan', 'dibaca_at', 'selesai_at'])
            ->withTimestamps();
    }

    public function tindakan()
    {
        return $this->hasMany(DisposisiTindakan::class)->orderBy('urutan');
    }

    public function isOverdue(): bool
    {
        return $this->batas_waktu && $this->batas_waktu->isPast() && $this->status !== 'selesai';
    }

    public function getPrioritasBadgeAttribute(): string
    {
        return match ($this->prioritas) {
            'tinggi' => 'bg-orange-100 text-orange-700 ring-orange-200',
            'segera' => 'bg-red-100 text-red-700 ring-red-200',
            'rendah' => 'bg-slate-100 text-slate-600 ring-slate-200',
            default => 'bg-blue-100 text-blue-700 ring-blue-200',
        };
    }

    public static function generateKode(): string
    {
        $year = date('Y');
        $month = date('m');
        $count = static::whereYear('created_at', $year)->whereMonth('created_at', $month)->count() + 1;
        return sprintf('DSP-%s%s-%04d', $year, $month, $count);
    }
}
