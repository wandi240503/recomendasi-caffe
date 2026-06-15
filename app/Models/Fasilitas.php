<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';

    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    /**
     * Relasi many-to-many ke Cafe
     */
    public function cafes(): BelongsToMany
    {
        return $this->belongsToMany(Cafe::class, 'cafe_fasilitas')
                    ->withTimestamps();
    }
}
