<?php

namespace App\Services;

use App\Models\Cafe;
use App\Models\Fasilitas;

class RecommendationService
{
    /**
     * Hitung Cosine Similarity antara dua vector
     *
     * Formula: cos(θ) = (A · B) / (|A| × |B|)
     *
     * @param array $vectorA User preference vector
     * @param array $vectorB Cafe facility vector
     * @return float Similarity score (0 to 1)
     */
    public function cosineSimilarity(array $vectorA, array $vectorB): float
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        for ($i = 0; $i < count($vectorA); $i++) {
            $dotProduct += $vectorA[$i] * $vectorB[$i];
            $magnitudeA += $vectorA[$i] ** 2;
            $magnitudeB += $vectorB[$i] ** 2;
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        // Hindari pembagian dengan nol
        if ($magnitudeA == 0 || $magnitudeB == 0) {
            return 0;
        }

        return $dotProduct / ($magnitudeA * $magnitudeB);
    }

    /**
     * Buat vector dari preferensi user
     *
     * @param array $selectedFasilitasIds ID fasilitas yang dipilih user
     * @param array $allFasilitasIds Semua ID fasilitas yang tersedia
     * @return array Binary vector [1, 0, 1, 1, 0, ...]
     */
    public function createUserVector(array $selectedFasilitasIds, array $allFasilitasIds): array
    {
        $vector = [];
        foreach ($allFasilitasIds as $id) {
            $vector[] = in_array($id, $selectedFasilitasIds) ? 1 : 0;
        }
        return $vector;
    }

    /**
     * Buat vector dari fasilitas cafe
     *
     * @param Cafe $cafe
     * @param array $allFasilitasIds Semua ID fasilitas yang tersedia
     * @return array Binary vector [1, 0, 1, 1, 0, ...]
     */
    public function createCafeVector(Cafe $cafe, array $allFasilitasIds): array
    {
        $cafeFasilitasIds = $cafe->fasilitas->pluck('id')->toArray();
        $vector = [];
        foreach ($allFasilitasIds as $id) {
            $vector[] = in_array($id, $cafeFasilitasIds) ? 1 : 0;
        }
        return $vector;
    }

    /**
     * Dapatkan rekomendasi cafe berdasarkan preferensi user
     *
     * Alur:
     * 1. Ambil semua fasilitas sebagai dimensi vector
     * 2. Buat user vector dari preferensi
     * 3. Buat cafe vector untuk setiap cafe
     * 4. Hitung cosine similarity
     * 5. Urutkan dari tertinggi
     *
     * @param array $selectedFasilitasIds ID fasilitas yang dipilih user
     * @return array Hasil rekomendasi dengan similarity score
     */
    public function getRecommendations(array $selectedFasilitasIds): array
    {
        // Ambil semua fasilitas sebagai dimensi vector
        $allFasilitas = Fasilitas::orderBy('id')->get();
        $allFasilitasIds = $allFasilitas->pluck('id')->toArray();

        // Buat user preference vector
        $userVector = $this->createUserVector($selectedFasilitasIds, $allFasilitasIds);

        // Ambil semua cafe aktif dengan fasilitas
        $cafes = Cafe::with(['fasilitas', 'fotos'])
            ->where('is_active', true)
            ->get();

        $results = [];

        foreach ($cafes as $cafe) {
            // Buat cafe vector
            $cafeVector = $this->createCafeVector($cafe, $allFasilitasIds);

            // Hitung cosine similarity
            $similarity = $this->cosineSimilarity($userVector, $cafeVector);

            // Hitung fasilitas yang match
            $matchedFasilitas = $cafe->fasilitas->whereIn('id', $selectedFasilitasIds);

            $results[] = [
                'cafe' => $cafe,
                'similarity' => round($similarity, 4),
                'percentage' => round($similarity * 100, 1),
                'user_vector' => $userVector,
                'cafe_vector' => $cafeVector,
                'matched_count' => $matchedFasilitas->count(),
                'total_selected' => count($selectedFasilitasIds),
                'matched_fasilitas' => $matchedFasilitas->pluck('name')->toArray(),
            ];
        }

        // Urutkan berdasarkan similarity tertinggi
        usort($results, function ($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        // Tambahkan ranking
        foreach ($results as $index => &$result) {
            $result['rank'] = $index + 1;
        }

        return $results;
    }
}
