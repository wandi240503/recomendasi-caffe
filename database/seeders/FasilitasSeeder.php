<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitasList = [
            ['name' => 'Indoor', 'slug' => 'indoor', 'icon' => '🏠'],
            ['name' => 'Outdoor', 'slug' => 'outdoor', 'icon' => '🌿'],
            ['name' => 'Rooftop', 'slug' => 'rooftop', 'icon' => '🌆'],
            ['name' => 'Smoking Area', 'slug' => 'smoking-area', 'icon' => '🚬'],
            ['name' => 'WiFi', 'slug' => 'wifi', 'icon' => '📶'],
            ['name' => 'AC', 'slug' => 'ac', 'icon' => '❄️'],
            ['name' => 'Spot Foto', 'slug' => 'spot-foto', 'icon' => '📸'],
            ['name' => 'Live Music', 'slug' => 'live-music', 'icon' => '🎵'],
            ['name' => 'Bilyard', 'slug' => 'bilyard', 'icon' => '🎱'],
            ['name' => 'Sofa', 'slug' => 'sofa', 'icon' => '🛋️'],
            ['name' => 'Western', 'slug' => 'western', 'icon' => '🍔'],
            ['name' => 'Estetik', 'slug' => 'estetik', 'icon' => '✨'],
            ['name' => 'Premium', 'slug' => 'premium', 'icon' => '💎'],
            ['name' => 'Work-from-cafe', 'slug' => 'work-from-cafe', 'icon' => '💻'],
            ['name' => 'Transit', 'slug' => 'transit', 'icon' => '🚉'],
            ['name' => 'Malioboro View', 'slug' => 'malioboro-view', 'icon' => '⛰️'],
            ['name' => 'Traditional', 'slug' => 'traditional', 'icon' => '🏮'],
            ['name' => 'Affordable', 'slug' => 'affordable', 'icon' => '🏷️'],
            ['name' => 'Vintage', 'slug' => 'vintage', 'icon' => '🕰️'],
            ['name' => 'Heritage', 'slug' => 'heritage', 'icon' => '🏛️'],
            ['name' => 'Calm', 'slug' => 'calm', 'icon' => '🤫'],
            ['name' => 'Coffee-focused', 'slug' => 'coffee-focused', 'icon' => '☕'],
            ['name' => 'Minimalis', 'slug' => 'minimalis', 'icon' => '📐'],
            ['name' => 'Spacious', 'slug' => 'spacious', 'icon' => '🌌'],
            ['name' => 'Student-friendly', 'slug' => 'student-friendly', 'icon' => '🎓'],
            ['name' => 'Modern', 'slug' => 'modern', 'icon' => '🏢'],
            ['name' => 'Meeting-room', 'slug' => 'meeting-room', 'icon' => '🚪'],
            ['name' => 'Pusat-Kota', 'slug' => 'pusat-kota', 'icon' => '📍'],
            ['name' => 'Javanese', 'slug' => 'javanese', 'icon' => '🎋'],
            ['name' => 'Kraton-vibes', 'slug' => 'kraton-vibes', 'icon' => '👑'],
            ['name' => 'Culture', 'slug' => 'culture', 'icon' => '🎭'],
            ['name' => 'Compact', 'slug' => 'compact', 'icon' => '📦'],
            ['name' => 'Quick-stop', 'slug' => 'quick-stop', 'icon' => '⚡'],
            ['name' => 'Artisan', 'slug' => 'artisan', 'icon' => '🎨'],
            ['name' => 'Tourist-friendly', 'slug' => 'tourist-friendly', 'icon' => '🗺️'],
            ['name' => 'Eco-friendly', 'slug' => 'eco-friendly', 'icon' => '♻️'],
            ['name' => 'Social-space', 'slug' => 'social-space', 'icon' => '👥'],
            ['name' => 'Rustic', 'slug' => 'rustic', 'icon' => '🪵'],
            ['name' => 'Garden', 'slug' => 'garden', 'icon' => '🏡'],
            ['name' => 'Rimbun', 'slug' => 'rimbun', 'icon' => '🌳'],
            ['name' => 'Co-working', 'slug' => 'co-working', 'icon' => '💻'],
            ['name' => '24-Hours', 'slug' => '24-hours', 'icon' => '⏰'],
            ['name' => 'Casual', 'slug' => 'casual', 'icon' => '👕'],
            ['name' => 'Industrial', 'slug' => 'industrial', 'icon' => '🏭'],
            ['name' => 'Pet-friendly', 'slug' => 'pet-friendly', 'icon' => '🐾'],
            ['name' => 'Family-friendly', 'slug' => 'family-friendly', 'icon' => '👨‍👩‍👧‍👦'],
            ['name' => 'White-aesthetic', 'slug' => 'white-aesthetic', 'icon' => '🤍'],
            ['name' => 'Hidden-gem', 'slug' => 'hidden-gem', 'icon' => '🔍'],
            ['name' => 'Retro', 'slug' => 'retro', 'icon' => '📻'],
            ['name' => 'Cozy', 'slug' => 'cozy', 'icon' => '🧸'],
            ['name' => 'City-view', 'slug' => 'city-view', 'icon' => '🏙️'],
            ['name' => 'Midnight-open', 'slug' => 'midnight-open', 'icon' => '🌃'],
            ['name' => 'Sunset-view', 'slug' => 'sunset-view', 'icon' => '🌅'],
            ['name' => 'Relaxed', 'slug' => 'relaxed', 'icon' => '🧘'],
        ];

        foreach ($fasilitasList as $fasilitas) {
            Fasilitas::updateOrCreate(
                ['slug' => $fasilitas['slug']],
                [
                    'name' => $fasilitas['name'],
                    'icon' => $fasilitas['icon'],
                ]
            );
        }
    }
}
