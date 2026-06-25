<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CafeController as AdminCafeController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CafeController;
use App\Http\Controllers\User\RekomendasiController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cafe', [CafeController::class, 'index'])->name('cafe.index');
Route::get('/cafe/{slug}', [CafeController::class, 'show'])->name('cafe.show');

Route::get('/rekomendasi', [RekomendasiController::class, 'form'])->name('rekomendasi.form');
Route::post('/rekomendasi', [RekomendasiController::class, 'hasil'])->name('rekomendasi.hasil');

Route::get('/tentang', function () {
    return view('user.about');
})->name('about');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Cafe
    Route::get('/cafe', [AdminCafeController::class, 'index'])->name('admin.cafe.index');
    Route::get('/cafe/create', [AdminCafeController::class, 'create'])->name('admin.cafe.create');
    Route::post('/cafe', [AdminCafeController::class, 'store'])->name('admin.cafe.store');
    Route::get('/cafe/{cafe}/edit', [AdminCafeController::class, 'edit'])->name('admin.cafe.edit');
    Route::put('/cafe/{cafe}', [AdminCafeController::class, 'update'])->name('admin.cafe.update');
    Route::delete('/cafe/{cafe}', [AdminCafeController::class, 'destroy'])->name('admin.cafe.destroy');

    // CRUD Fasilitas
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('admin.fasilitas.index');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('admin.fasilitas.store');
    Route::put('/fasilitas/{fasilitas}', [FasilitasController::class, 'update'])->name('admin.fasilitas.update');
    Route::delete('/fasilitas/{fasilitas}', [FasilitasController::class, 'destroy'])->name('admin.fasilitas.destroy');
});

/*
|--------------------------------------------------------------------------
| Import Route (For Vercel Deployment)
|--------------------------------------------------------------------------
*/

Route::get('/import-database', function () {
    try {
        // Hapus tabel secara manual satu per satu untuk menghindari error PgBouncer saat migrate:fresh
        $tables = [
            'cafe_fasilitas', 'foto_cafes', 'cafes', 'fasilitas', 'admins', 
            'users', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks', 
            'jobs', 'job_batches', 'failed_jobs', 'migrations'
        ];
        
        foreach ($tables as $table) {
            try {
                \Illuminate\Support\Facades\DB::statement("DROP TABLE IF EXISTS {$table} CASCADE");
            } catch (\Exception $e) {
                // Abaikan error drop jika tabel bermasalah
            }
        }
        
        // Buat ulang semua tabel dengan bersih
        \Illuminate\Support\Facades\Artisan::call('migrate', [
            '--force' => true
        ]);
        
        // Masukkan data 50 Cafe
        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--force' => true
        ]);
        
        return "Migrasi dan Seeding Database berhasil 100%! Data cafe sudah siap digunakan.";
    } catch (\Exception $e) {
        return "Error saat memasukkan data: " . $e->getMessage();
    }
});
