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

        // Upload foto ke Cloudinary
        if ($request->hasFile('foto')) {
            // Inisialisasi Cloudinary dengan kredensial .env (atau fallback)
            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'dlbr86qnd'),
                'api_key'    => env('CLOUDINARY_API_KEY', '852678874433293'),
                'api_secret' => env('CLOUDINARY_API_SECRET', 'DbzTppxmjvmGybgyFdmNkgWy7Tk'),
                'secure' => true,
            ]);
            $uploadResult = $cloudinary->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                [
                    'folder' => 'cafes',
                    'public_id' => \Illuminate\Support\Str::slug($validated['name']) . '_' . time(),
                ]
            );
            $url = $uploadResult['secure_url'];
            FotoCafe::create([
                'cafe_id' => $cafe->id,
                'url' => $url,
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

        // Upload foto baru ke Cloudinary
        if ($request->hasFile('foto')) {
            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'dlbr86qnd'),
                'api_key'    => env('CLOUDINARY_API_KEY', '852678874433293'),
                'api_secret' => env('CLOUDINARY_API_SECRET', 'DbzTppxmjvmGybgyFdmNkgWy7Tk'),
                'secure' => true,
            ]);
            $uploadResult = $cloudinary->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                [
                    'folder' => 'cafes',
                    'public_id' => \Illuminate\Support\Str::slug($cafe->name) . '_' . time(),
                ]
            );
            $url = $uploadResult['secure_url'];
            // Set semua foto lain jadi non-primary
            $cafe->fotos()->update(['is_primary' => false]);
            FotoCafe::create([
                'cafe_id' => $cafe->id,
                'url' => $url,
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

    public function uploadGallery(Request $request, Cafe $cafe)
    {
        $request->validate([
            'gallery_fotos' => ['required', 'array'],
            'gallery_fotos.*' => ['image', 'max:5120'], // maks 5MB per foto
        ]);

        if ($request->hasFile('gallery_fotos')) {
            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'dlbr86qnd'),
                'api_key'    => env('CLOUDINARY_API_KEY', '852678874433293'),
                'api_secret' => env('CLOUDINARY_API_SECRET', 'DbzTppxmjvmGybgyFdmNkgWy7Tk'),
                'secure' => true,
            ]);

            foreach ($request->file('gallery_fotos') as $index => $file) {
                $uploadResult = $cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder' => 'cafes_gallery',
                        'public_id' => \Illuminate\Support\Str::slug($cafe->name) . '_gallery_' . time() . '_' . $index,
                    ]
                );
                
                $url = $uploadResult['secure_url'];
                
                FotoCafe::create([
                    'cafe_id' => $cafe->id,
                    'url' => $url,
                    'is_primary' => false,
                    'caption' => $cafe->name . ' Gallery',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Foto-foto galeri berhasil ditambahkan!');
    }

    public function deleteFoto(FotoCafe $foto)
    {
        $cafe = $foto->cafe;

        // Jangan hapus jika foto tersebut adalah foto primary satu-satunya
        if ($foto->is_primary) {
            $anotherPhoto = $cafe->fotos()->where('id', '!=', $foto->id)->first();
            if ($anotherPhoto) {
                $anotherPhoto->update(['is_primary' => true]);
            }
        }

        // Hapus file dari Cloudinary (jika URL adalah Cloudinary)
        if (str_contains($foto->url, 'res.cloudinary.com')) {
            try {
                $pathParts = explode('/image/upload/', $foto->url);
                if (count($pathParts) > 1) {
                    $afterUpload = explode('/', $pathParts[1]);
                    array_shift($afterUpload);
                    $filename = implode('/', $afterUpload);
                    $publicId = pathinfo($filename, PATHINFO_DIRNAME) . '/' . pathinfo($filename, PATHINFO_FILENAME);
                    if (pathinfo($filename, PATHINFO_DIRNAME) === '.') {
                        $publicId = pathinfo($filename, PATHINFO_FILENAME);
                    }

                    $cloudinary = new \Cloudinary\Cloudinary([
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'dlbr86qnd'),
                        'api_key'    => env('CLOUDINARY_API_KEY', '852678874433293'),
                        'api_secret' => env('CLOUDINARY_API_SECRET', 'DbzTppxmjvmGybgyFdmNkgWy7Tk'),
                        'secure' => true,
                    ]);
                    $cloudinary->uploadApi()->destroy($publicId);
                }
            } catch (\Exception $e) {
                // Abaikan error hapus Cloudinary agar data DB tetap bisa dihapus
            }
        }

        $foto->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }
}
