<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Fasilitas;
use App\Models\FotoCafe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CafeController extends Controller
{
    public function index()
    {
        $cafes = Cafe::with(['fasilitas', 'fotos'])->latest()->paginate(10);
        return view('admin.cafe.index', compact('cafes'));
    }

    public function create()
    {
        $fasilitas = Fasilitas::all();
        return view('admin.cafe.create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'kemantren' => ['nullable', 'string', 'max:255'],
            'konsep_utama' => ['nullable', 'string', 'max:255'],
            'gmaps_url' => ['nullable', 'url'],
            'open_time' => ['required', 'string'],
            'close_time' => ['required', 'string'],
            'avg_price' => ['required', 'integer', 'min:0'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'fasilitas' => ['nullable', 'array'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $cafe = Cafe::create($validated);

        // Attach fasilitas
        if ($request->has('fasilitas')) {
            $cafe->fasilitas()->attach($request->fasilitas);
        }

        // Upload foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('cafes', 'public');
            FotoCafe::create([
                'cafe_id' => $cafe->id,
                'url' => '/storage/' . $path,
                'is_primary' => true,
                'caption' => $cafe->name,
            ]);
        }

        return redirect()->route('admin.cafe.index')
            ->with('success', 'Cafe "' . $cafe->name . '" berhasil ditambahkan!');
    }

    public function edit(Cafe $cafe)
    {
        $cafe->load('fasilitas');
        $fasilitas = Fasilitas::all();
        return view('admin.cafe.edit', compact('cafe', 'fasilitas'));
    }

    public function update(Request $request, Cafe $cafe)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'kemantren' => ['nullable', 'string', 'max:255'],
            'konsep_utama' => ['nullable', 'string', 'max:255'],
            'gmaps_url' => ['nullable', 'url'],
            'open_time' => ['required', 'string'],
            'close_time' => ['required', 'string'],
            'avg_price' => ['required', 'integer', 'min:0'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'fasilitas' => ['nullable', 'array'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $cafe->update($validated);

        // Sync fasilitas
        $cafe->fasilitas()->sync($request->fasilitas ?? []);

        // Upload foto baru
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('cafes', 'public');
            // Set semua foto lain jadi non-primary
            $cafe->fotos()->update(['is_primary' => false]);
            FotoCafe::create([
                'cafe_id' => $cafe->id,
                'url' => '/storage/' . $path,
                'is_primary' => true,
                'caption' => $cafe->name,
            ]);
        }

        return redirect()->route('admin.cafe.index')
            ->with('success', 'Cafe "' . $cafe->name . '" berhasil diupdate!');
    }

    public function destroy(Cafe $cafe)
    {
        $name = $cafe->name;
        $cafe->delete();

        return redirect()->route('admin.cafe.index')
            ->with('success', 'Cafe "' . $name . '" berhasil dihapus!');
    }
}
