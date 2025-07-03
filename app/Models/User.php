<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nim',
        'role',
        'password',
        'verification',
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

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    // Relasi sebagai ketua kandidat
    public function chairmanCandidates()
    {
        return $this->hasMany(Candidate::class, 'chairman_id');
    }

    // Relasi sebagai wakil ketua kandidat
    public function viceChairmanCandidates()
    {
        return $this->hasMany(Candidate::class, 'vice_chairman_id');
    }

    // Relasi sebagai pemilih
    public function votes()
    {
        return $this->hasMany(Vote::class, 'voter_id');
    }

    // Scope untuk admin
    public function scopeAdmins($query)
    {
        return $query->where('role', 'Admin');
    }

    // Scope untuk mahasiswa
    public function scopeStudents($query)
    {
        return $query->where('role', 'Mahasiswa');
    }
}
