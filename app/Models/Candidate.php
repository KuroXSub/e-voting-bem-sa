<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'election_period_id',
        'chairman_id',
        'vice_chairman_id',
        'number',
        'vision',
        'mission',
        'photo_url',
    ];

    protected $appends = ['photo_path'];

    // Relasi dengan periode pemilihan
    public function electionPeriod()
    {
        return $this->belongsTo(ElectionPeriod::class);
    }

    // Relasi dengan ketua
    public function chairman()
    {
        return $this->belongsTo(User::class, 'chairman_id');
    }

    // Relasi dengan wakil ketua
    public function viceChairman()
    {
        return $this->belongsTo(User::class, 'vice_chairman_id');
    }

    // Relasi dengan vote
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Format nomor kandidat
    public function getFormattedNumberAttribute()
    {
        return str_pad($this->number, 2, '0', STR_PAD_LEFT);
    }

    // Hitung total suara
    public function getVoteCountAttribute()
    {
        return $this->votes()->count();
    }

    // Cek apakah ketua dan wakil berbeda
    public function isTeamValid()
    {
        return $this->chairman_id !== $this->vice_chairman_id;
    }

    public function getPhotoPathAttribute()
    {
        if (!$this->photo_url) {
            return null;
        }
        
        return asset('storage/' . $this->photo_url);
    }

    protected static function booted()
    {
        static::deleting(function ($candidate) {
            if ($candidate->photo_url && Storage::exists('public/' . $candidate->photo_url)) {
                Storage::delete('public/' . $candidate->photo_url);
            }
        });
    }
}
