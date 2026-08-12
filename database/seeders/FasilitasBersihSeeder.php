<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Cafe;
use App\Models\Fasilitas;

class FasilitasBersihSeeder extends Seeder
{
    /**
     * 20 Fasilitas Inti (bersih, tanpa duplikat)
     */
    private array $fasilitasInti = [
        ['name' => 'Indoor',          'icon' => '🏠'],
        ['name' => 'Outdoor',         'icon' => '🌿'],
        ['name' => 'Semi-Outdoor',    'icon' => '⛅'],
        ['name' => 'Rooftop',         'icon' => '🌆'],
        ['name' => 'AC',              'icon' => '❄️'],
        ['name' => 'WiFi',            'icon' => '📶'],
        ['name' => 'Smoking Area',    'icon' => '🚬'],
        ['name' => 'Colokan/Charger', 'icon' => '🔌'],
        ['name' => 'Meja Kerja',      'icon' => '💻'],
        ['name' => 'Meeting Room',    'icon' => '🏢'],
        ['name' => 'Live Music',      'icon' => '🎵'],
        ['name' => 'Pet-Friendly',    'icon' => '🐾'],
        ['name' => 'Spot Foto',       'icon' => '📸'],
        ['name' => 'Sofa',            'icon' => '🛋️'],
        ['name' => 'Student-Friendly','icon' => '🎓'],
        ['name' => 'Heritage/Vintage','icon' => '🏛️'],
        ['name' => 'Garden/Taman',    'icon' => '🌳'],
        ['name' => 'Affordable',      'icon' => '💰'],
        ['name' => 'Buka 24 Jam',     'icon' => '🕐'],
        ['name' => 'Specialty Coffee','icon' => '☕'],
    ];

    /**
     * Pemetaan: nama cafe => [daftar fasilitas inti yang dimiliki]
     * Berdasarkan data asli masing-masing cafe
     */
    private array $cafeFasilitas = [
        'Blanco Coffee & Books'        => ['Indoor', 'AC', 'WiFi', 'Colokan/Charger', 'Meja Kerja'],
        'Loko Cafe Malioboro'          => ['Outdoor', 'Semi-Outdoor', 'WiFi', 'Live Music'],
        'Lecker Rumah Kopi'            => ['Indoor', 'Outdoor', 'WiFi', 'Smoking Area', 'Heritage/Vintage'],
        'Kala Jumpa'                   => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Student-Friendly', 'Meja Kerja'],
        'Luxury Bench'                 => ['Indoor', 'AC', 'Meeting Room'],
        'Civet Coffee Malioboro'       => ['Indoor', 'AC', 'WiFi', 'Heritage/Vintage'],
        'Kopi Opak (Kotabaru Branch)'  => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Colokan/Charger'],
        'Kala Kopi'                    => ['Indoor', 'AC', 'Affordable'],
        'ViaVia Cafe'                  => ['Indoor', 'Outdoor', 'WiFi', 'Spot Foto'],
        'Warung Lawas'                 => ['Outdoor', 'Semi-Outdoor', 'WiFi'],
        'Jiwa Jawi'                    => ['Outdoor', 'Garden/Taman', 'Heritage/Vintage'],
        'Sinergi Coworking Space'      => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Colokan/Charger', 'Meja Kerja', 'Buka 24 Jam'],
        'Selasar Malioboro Cafe'       => ['Outdoor', 'Smoking Area', 'Live Music', 'Affordable'],
        'Artemis Coffee & Space'       => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Student-Friendly', 'Meja Kerja'],
        'LeGatito Cafe'                => ['Indoor', 'AC', 'WiFi', 'Pet-Friendly', 'Sofa'],
        'Kedai Kopi Mataram'           => ['Indoor', 'Outdoor', 'Heritage/Vintage', 'Affordable'],
        'Dua Coffee Malioboro'         => ['Indoor', 'AC', 'WiFi', 'Meja Kerja', 'Specialty Coffee'],
        'Metropole Coffee'             => ['Indoor', 'Outdoor', 'AC', 'Heritage/Vintage', 'Spot Foto'],
        'Estuary Cafe'                 => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Meja Kerja'],
        'Kopi Kebon'                   => ['Outdoor', 'Garden/Taman'],
        'Gramika Space'                => ['Indoor', 'Outdoor', 'Student-Friendly', 'Affordable'],
        'Sujiwa Coffee'                => ['Indoor', 'Outdoor', 'Heritage/Vintage'],
        'Kopi Pojok Tamansari'         => ['Outdoor', 'Semi-Outdoor', 'Heritage/Vintage'],
        'Tujuan Cafe'                  => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Spot Foto', 'Heritage/Vintage'],
        'Kala di Atas'                 => ['Outdoor', 'Rooftop', 'Live Music'],
        'Awor Coffee'                  => ['Indoor', 'AC', 'Meja Kerja', 'Specialty Coffee'],
        'Sore Sore Coffee'             => ['Outdoor', 'Affordable'],
        'Couvee Ahmad Dahlan'          => ['Indoor', 'AC', 'WiFi', 'Meja Kerja', 'Specialty Coffee'],
        'Eplus Co-working Cafe'        => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Colokan/Charger', 'Meja Kerja', 'Meeting Room'],
        'Peacockoffie'                 => ['Indoor', 'Semi-Outdoor', 'AC', 'WiFi', 'Colokan/Charger', 'Meja Kerja'],
        'Nox Coffee Boutique'          => ['Indoor', 'AC', 'WiFi', 'Sofa', 'Meeting Room', 'Specialty Coffee'],
        'Kopi nDalem'                  => ['Outdoor', 'Garden/Taman', 'Heritage/Vintage'],
        'Simetri Coffee Roasters'      => ['Indoor', 'Outdoor', 'AC', 'Garden/Taman', 'Meja Kerja', 'Specialty Coffee'],
        'Space Coffee Roastery'        => ['Indoor', 'Outdoor', 'AC', 'Specialty Coffee'],
        'Le Mindon'                    => ['Indoor', 'Outdoor', 'Sofa', 'Heritage/Vintage'],
        'Hayati Specialty Coffee'      => ['Indoor', 'AC', 'WiFi', 'Meja Kerja', 'Specialty Coffee'],
        'Sugoi Kopi'                   => ['Indoor', 'Outdoor', 'AC', 'Student-Friendly', 'Affordable', 'Spot Foto'],
        'English Ivy Coffee'           => ['Indoor', 'Outdoor', 'Garden/Taman', 'Meja Kerja'],
        'Kopi Opak City Branch'        => ['Outdoor', 'Smoking Area', 'Affordable'],
        'Seniman Kopi Jogja'           => ['Semi-Outdoor', 'Smoking Area', 'Heritage/Vintage'],
        'Tengah Kota Kopi'             => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Colokan/Charger'],
        'Antek Coffee'                 => ['Indoor', 'Outdoor', 'AC', 'Student-Friendly', 'Affordable', 'Colokan/Charger'],
        'Brick Cafe City Spot'         => ['Indoor', 'Outdoor', 'Sofa', 'Heritage/Vintage', 'Spot Foto'],
        'Umar Kopi'                    => ['Indoor', 'Outdoor', 'WiFi', 'Student-Friendly', 'Affordable'],
        'Tugu Kopi Jogja'              => ['Outdoor', 'Semi-Outdoor', 'Heritage/Vintage'],
        'Janji Jiwa X Badak'           => ['Indoor', 'AC', 'WiFi'],
        'Pojok Kahfi'                  => ['Indoor', 'Outdoor', 'Affordable'],
        'Kotagede Heritage Coffee'     => ['Indoor', 'Outdoor', 'Heritage/Vintage'],
        'Ethikopia Coffee'             => ['Indoor', 'Outdoor', 'AC', 'WiFi', 'Colokan/Charger', 'Meja Kerja'],
        'Republic Cafe'                => ['Indoor', 'AC', 'Sofa', 'Meeting Room'],
    ];

    public function run(): void
    {
        $this->command->info('🧹 Membersihkan fasilitas lama...');

        // 1. Hapus semua relasi pivot
        DB::table('cafe_fasilitas')->delete();

        // 2. Hapus semua fasilitas lama
        DB::table('fasilitas')->delete();

        $this->command->info('✅ Lama dihapus. Memasukkan 20 fasilitas inti...');

        // 3. Insert fasilitas baru yang bersih
        foreach ($this->fasilitasInti as $f) {
            Fasilitas::create([
                'name' => $f['name'],
                'icon' => $f['icon'],
                'slug' => Str::slug($f['name']),
            ]);
        }

        // Buat map nama => id
        $fasilitasMap = Fasilitas::all()->keyBy('name');

        $this->command->info('🔗 Memetakan ulang fasilitas ke 50 cafe...');

        // 4. Pasang kembali relasi cafe <=> fasilitas
        foreach ($this->cafeFasilitas as $cafeName => $daftarFasilitas) {
            $cafe = Cafe::where('name', $cafeName)->first();
            if (!$cafe) {
                $this->command->warn("  ⚠️  Cafe tidak ditemukan: {$cafeName}");
                continue;
            }

            $ids = [];
            foreach ($daftarFasilitas as $fName) {
                if (isset($fasilitasMap[$fName])) {
                    $ids[] = $fasilitasMap[$fName]->id;
                } else {
                    $this->command->warn("  ⚠️  Fasilitas tidak ditemukan: {$fName}");
                }
            }

            $cafe->fasilitas()->sync($ids);
            $this->command->line("  ✓ {$cafeName} → " . count($ids) . " fasilitas");
        }

        $this->command->info('');
        $this->command->info('🎉 Selesai! Total fasilitas: ' . Fasilitas::count());
        $this->command->info('🎉 Total relasi: ' . DB::table('cafe_fasilitas')->count());
    }
}
