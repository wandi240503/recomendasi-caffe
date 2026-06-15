<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Rekomendasi;
use App\Models\Fasilitas;

class HomeController extends Controller
{
    public function index()
    {
        $cafePopuler = Cafe::with(['fasilitas', 'fotos'])
            ->where('is_active', true)
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get();

        $totalCafe = Cafe::where('is_active', true)->count();
        $totalRekomendasi = Rekomendasi::count();
        $totalFasilitas = Fasilitas::count();

        return view('user.home', compact('cafePopuler', 'totalCafe', 'totalRekomendasi', 'totalFasilitas'));
    }
}
