<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    /**
     * Daftar semua cafe dengan search & filter
     */
    public function index(Request $request)
    {
        $query = Cafe::with(['fasilitas', 'fotos'])->where('is_active', true);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by fasilitas
        if ($request->filled('fasilitas')) {
            $fasilitasIds = $request->fasilitas;
            $query->whereHas('fasilitas', function ($q) use ($fasilitasIds) {
                $q->whereIn('fasilitas.id', $fasilitasIds);
            });
        }

        $cafes = $query->orderBy('rating', 'desc')->paginate(9);
        $allFasilitas = Fasilitas::all();

        return view('user.cafe.index', compact('cafes', 'allFasilitas'));
    }

    /**
     * Detail cafe
     */
    public function show($slug)
    {
        $cafe = Cafe::with(['fasilitas', 'fotos'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $cafeSerupa = Cafe::with(['fasilitas', 'fotos'])
            ->where('id', '!=', $cafe->id)
            ->where('is_active', true)
            ->whereHas('fasilitas', function ($q) use ($cafe) {
                $q->whereIn('fasilitas.id', $cafe->fasilitas->pluck('id'));
            })
            ->take(3)
            ->get();

        return view('user.cafe.show', compact('cafe', 'cafeSerupa'));
    }
}
