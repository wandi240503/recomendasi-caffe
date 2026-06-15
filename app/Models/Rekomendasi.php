<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    protected $fillable = [
        'session_id',
        'preferensi_json',
        'hasil_json',
    ];

    protected function casts(): array
    {
        return [
            'preferensi_json' => 'array',
            'hasil_json' => 'array',
        ];
    }
}
