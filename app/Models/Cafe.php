<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cafe extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'kemantren',
        'konsep_utama',
        'gmaps_url',
        'open_time',
        'close_time',
        'avg_price',
        'rating',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'avg_price' => 'integer',
            'rating' => 'decimal:1',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi many-to-many ke Fasilitas
     */
    public function fasilitas(): BelongsToMany
    {
        return $this->belongsToMany(Fasilitas::class, 'cafe_fasilitas')
                    ->withTimestamps();
    }

    /**
     * Relasi one-to-many ke FotoCafe
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(FotoCafe::class);
    }

    /**
     * Ambil foto utama cafe
     */
    public function fotoPrimary()
    {
        return $this->fotos()->where('is_primary', true)->first();
    }

    /**
     * Format harga ke Rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->avg_price, 0, ',', '.');
    }
}
