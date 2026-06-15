<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Fasilitas;
use App\Models\Rekomendasi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCafe = Cafe::count();
        $totalFasilitas = Fasilitas::count();
        $totalRekomendasi = Rekomendasi::count();
        $cafeAktif = Cafe::where('is_active', true)->count();

        // Cafe terpopuler (paling banyak muncul di rekomendasi)
        $cafeTerbaru = Cafe::with('fasilitas')->latest()->take(5)->get();

        // Rekomendasi terbaru
        $rekomendasiTerbaru = Rekomendasi::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalCafe',
            'totalFasilitas',
            'totalRekomendasi',
            'cafeAktif',
            'cafeTerbaru',
            'rekomendasiTerbaru'
        ));
    }
}
