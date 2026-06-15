<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Rekomendasi;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    protected RecommendationService $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Form pilih preferensi
     */
    public function form()
    {
        $fasilitas = Fasilitas::all();
        return view('user.rekomendasi.form', compact('fasilitas'));
    }

    /**
     * Proses dan tampilkan hasil rekomendasi
     */
    public function hasil(Request $request)
    {
        $request->validate([
            'fasilitas' => ['required', 'array', 'min:1'],
            'fasilitas.*' => ['integer', 'exists:fasilitas,id'],
        ], [
            'fasilitas.required' => 'Pilih minimal 1 fasilitas untuk mendapatkan rekomendasi.',
            'fasilitas.min' => 'Pilih minimal 1 fasilitas untuk mendapatkan rekomendasi.',
        ]);

        $selectedIds = $request->fasilitas;

        // Jalankan algoritma rekomendasi
        $results = $this->recommendationService->getRecommendations($selectedIds);

        // Simpan log rekomendasi
        $selectedNames = Fasilitas::whereIn('id', $selectedIds)->pluck('name')->toArray();
        Rekomendasi::create([
            'session_id' => session()->getId(),
            'preferensi_json' => [
                'fasilitas_ids' => $selectedIds,
                'fasilitas_names' => $selectedNames,
            ],
            'hasil_json' => collect($results)->take(5)->map(function ($r) {
                return [
                    'cafe_id' => $r['cafe']->id,
                    'cafe_name' => $r['cafe']->name,
                    'similarity' => $r['similarity'],
                    'percentage' => $r['percentage'],
                ];
            })->toArray(),
        ]);

        $allFasilitas = Fasilitas::all();

        return view('user.rekomendasi.hasil', compact('results', 'selectedIds', 'allFasilitas', 'selectedNames'));
    }
}
