<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluars';

    protected $fillable = [
        'no_agenda',
        'no_surat',
        'tanggal_surat',
        'tanggal_kirim',
        'tujuan_surat',
        'disposisikan',
        'lokasi',
        'waktumulai',
        'waktuselesai',
        'perihal',
        'sifat',
        'lampiran',
        'keterangan',
        'file_surat',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_kirim' => 'date',

    ];

    public function getDisposisikanDisplayAttribute()
    {
        if (!empty($this->disposisikan)) {
            return $this->disposisikan;
        }
        return '-';
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'surat_keluar_id');
    }
    public function latestDisposisi()
    {
        return $this->hasOne(Disposisi::class, 'surat_keluar_id')->latest();
    }

    public static function generateNoAgenda(): string
    {
        $year = date('Y');
        $month = date('m');
        $count = static::whereYear('created_at', $year)->whereMonth('created_at', $month)->count() + 1;
        return sprintf('SK-%s%s-%04d', $year, $month, $count);
    }
    public function getTanggalSuratInputAttribute()
    {
        return $this->tanggal_surat?->format('Y-m-d');
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
}
