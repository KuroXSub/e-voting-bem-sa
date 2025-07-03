<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'election_period_id',
        'voter_id',
        'candidate_id',
        'voted_at',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    // Relasi dengan periode pemilihan
    public function electionPeriod()
    {
        return $this->belongsTo(ElectionPeriod::class);
    }

    // Relasi dengan pemilih
    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id');
    }

    // Relasi dengan kandidat
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    protected $appends = ['hashed_user'];

    protected static function booted()
    {
        // static::creating(function ($vote) {
        //     $vote->user_hash = static::generateUserHash($vote->voter_id);
        // });

        // static::updating(function ($vote) {
        //     if ($vote->isDirty('voter_id')) {
        //         $vote->user_hash = Vote::generateUserHash($vote->voter_id);
        //     }
        // });
    }

    public static function generateUserHash($voterId)
    {
        return substr(hash_hmac('sha256', $voterId, config('app.key')), 0, 12);
    }

    public function getHashedUserAttribute()
    {
        return 'Mahasiswa' . $this->generateUserHash($this->voter_id);
    }
}
