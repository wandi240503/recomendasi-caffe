<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class ScrapeCafePhotos extends Command
{
    /**
     * Nama dan signature perintah terminal.
     *
     * @var string
     */
    protected $signature = 'cafe:scrape-photos';

    /**
     * Deskripsi perintah terminal.
     *
     * @var string
     */
    protected $description = 'Scrape dan perbarui foto asli untuk seluruh 50 kafe dari internet ke SQLite';

    /**
     * Eksekusi perintah terminal.
     */
    public function handle()
    {
        $this->info('🚀 Memulai proses Web Scraping foto kafe...');

        $scriptPath = base_path('scrape_cafe_photos.py');

        // Jalankan script python menggunakan python3
        $result = Process::run("python3 \"{$scriptPath}\"");

        if ($result->successful()) {
            $this->line($result->output());
            $this->info('✅ Seluruh foto kafe berhasil di-scrape dan diperbarui!');
        } else {
            $this->error('❌ Terjadi kesalahan saat menjalankan scraper:');
            $this->error($result->errorOutput());
        }

        return Command::SUCCESS;
    }
}
