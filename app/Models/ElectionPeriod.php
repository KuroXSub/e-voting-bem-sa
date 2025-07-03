<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElectionPeriod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
        'status',
        'description',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($period) {
            // Daftar status yang hanya boleh ada satu instance aktif pada satu waktu
            $uniqueStatuses = ['Belum dimulai', 'Sedang Berlangsung', 'Telah Selesai'];

            // Jika status yang diubah termasuk dalam uniqueStatuses
            if ($period->isDirty('status') && in_array($period->status, $uniqueStatuses)) {
                self::where('id', '!=', $period->id)
                    ->whereIn('status', $uniqueStatuses) // Check di antara semua uniqueStatuses
                    ->update(['status' => 'Non-aktif']);
            }

            // Logika khusus untuk is_active: hanya true jika status "Sedang Berlangsung"
            if ($period->isDirty('status') || $period->isDirty('is_active')) {
                if ($period->status === 'Sedang Berlangsung') {
                    $period->is_active = true;
                } else {
                    $period->is_active = false;
                }
            }
        });

        // Event afterSave untuk memastikan konsistensi setelah model disimpan
        static::saved(function ($period) {
            if ($period->status === 'Sedang Berlangsung') {
                self::where('id', '!=', $period->id)
                    ->update([
                        'is_active' => false,
                        'status' => 'Non-aktif'
                    ]);
            }

            elseif (in_array($period->status, ['Belum dimulai', 'Telah Selesai'])) {
                 self::where('id', '!=', $period->id)
                    ->where('status', $period->status) // hanya menargetkan status yang sama
                    ->update(['status' => 'Non-aktif']);
            }
        });
    }

    // Relasi dengan kandidat
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    // Relasi dengan vote
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Scope aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Cek apakah periode sedang berlangsung
    public function isRunning()
    {
        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    // Aktifkan periode ini dan nonaktifkan yang lain
    public function activate()
    {
        ElectionPeriod::where('id', '!=', $this->id)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

    public static function rules(): array
    {
        return [
            'start_date' => ['required', 'date'],
            'end_date' => [
                'required', 
                'date',
                'after:start_date'
            ],
        ];
    }
}
