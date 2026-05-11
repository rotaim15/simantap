<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuks';
    protected $fillable = [
        'no_agenda',
        'no_surat',
        'tanggal_surat',
        'tanggal_terima',
        'waktumulai',
        'waktuselesai',
        'asal_surat',
        'disposisikan',
        'lokasi',
        'perihal',
        'sifat',
        'klasifikasi',
        'lampiran',
        'keterangan',
        'file_surat',
        'status',
        'created_by',
    ];
    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_terima' => 'date',
        // 'disposisikan' => 'array',
    ];
    public function getDisposisikanDisplayAttribute()
    {
        if (!empty($this->disposisikan)) {
            return  $this->disposisikan;
        }
        return '-';
    }
    public function getTanggalSuratInputAttribute()
    {
        return $this->tanggal_surat?->format('Y-m-d');
    }

    public function getTanggalTerimaInputAttribute()
    {
        return $this->tanggal_terima?->format('Y-m-d');
    }

    public function getWaktuMulaiInputAttribute()
    {
        return $this->waktumulai
            ? \Carbon\Carbon::parse($this->waktumulai)->format('H:i')
            : null;
    }

    public function getWaktuSelesaiInputAttribute()
    {
        return $this->waktuselesai
            ? \Carbon\Carbon::parse($this->waktuselesai)->format('H:i')
            : null;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }

    public function latestDisposisi()
    {
        return $this->hasOne(Disposisi::class, 'surat_masuk_id')->latest();
    }

    public function getSifatBadgeAttribute(): string
    {
        return match ($this->sifat) {
            'penting' => 'badge-penting',
            'rahasia' => 'badge-rahasia',
            'sangat_rahasia' => 'badge-sangat-rahasia',
            default => 'badge-biasa',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'diproses' => 'badge-diproses',
            'selesai' => 'badge-selesai',
            'ditolak' => 'badge-ditolak',
            default => 'badge-pending',
        };
    }

    public static function generateNoAgenda(): string
    {
        $year = date('Y');
        $month = date('m');
        $count = static::whereYear('created_at', $year)->whereMonth('created_at', $month)->count() + 1;
        return sprintf('SM-%s%s-%04d', $year, $month, $count);
    }
}
