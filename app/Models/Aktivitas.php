<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    protected $fillable = [
        'user_id',
        'aksi',
        'model_type',
        'model_id',
        'deskripsi',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function catat(string $aksi, Model $model, string $deskripsi = ''): void
    {
        if (auth()->check()) {
            static::create([
                'user_id' => auth()->id(),
                'aksi' => $aksi,
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'deskripsi' => $deskripsi,
                'ip_address' => request()->ip(),
            ]);
        }
    }
}
