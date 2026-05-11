<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }
    public function isAdmin(): bool
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }
    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    public function suratMasukDibuat()
    {
        return $this->hasMany(SuratMasuk::class, 'created_by');
    }

    public function disposisiDibuat()
    {
        return $this->hasMany(Disposisi::class, 'dari_user_id');
    }

    public function disposisiDiterima()
    {
        return $this->belongsToMany(Disposisi::class, 'disposisi_penerima', 'user_id', 'disposisi_id')
            ->withPivot(['status', 'tanggapan', 'dibaca_at', 'selesai_at'])
            ->withTimestamps();
    }

    public function disposisiPendingCount(): int
    {
        return $this->disposisiDiterima()
            ->wherePivotIn('status', ['belum_dibaca', 'dibaca', 'diproses'])
            ->count();
    }

    public function getAvatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0284c7&color=fff&size=128';
    }
}
