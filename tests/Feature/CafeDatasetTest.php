<?php

namespace Tests\Feature;

use App\Models\Cafe;
use App\Models\Fasilitas;
use App\Services\RecommendationService;
use Database\Seeders\FasilitasSeeder;
use Database\Seeders\CafeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CafeDatasetTest extends TestCase
{
    use RefreshDatabase;

    public function test_cafes_and_facilities_are_seeded_correctly(): void
    {
        $this->seed(FasilitasSeeder::class);
        $this->seed(CafeSeeder::class);

        // Assert 30 cafes are seeded
        $this->assertEquals(30, Cafe::count());

        // Assert facilities are seeded
        $this->assertGreaterThan(10, Fasilitas::count());

        // Verify specific cafe details (Roaster and Bear)
        $roasterAndBear = Cafe::where('slug', 'roaster-and-bear')->first();
        $this->assertNotNull($roasterAndBear);
        $this->assertEquals('Jetis', $roasterAndBear->kemantren);
        $this->assertEquals('Dominan Indoor', $roasterAndBear->konsep_utama);
        $this->assertTrue($roasterAndBear->fasilitas->contains('slug', 'ac'));
        $this->assertTrue($roasterAndBear->fasilitas->contains('slug', 'sofa'));
    }

    public function test_recommendation_caculate_similarity(): void
    {
        $this->seed(FasilitasSeeder::class);
        $this->seed(CafeSeeder::class);

        $service = new RecommendationService();
        $ac = Fasilitas::where('slug', 'ac')->first();
        $sofa = Fasilitas::where('slug', 'sofa')->first();

        // user prefers AC and Sofa
        $results = $service->getRecommendations([$ac->id, $sofa->id]);

        $this->assertNotEmpty($results);
        $firstMatch = $results[0];
        $this->assertEquals('Roaster and Bear', $firstMatch['cafe']->name);
        $this->assertGreaterThan(0, $firstMatch['similarity']);
    }
}
