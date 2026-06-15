<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExportDbJson extends Command
{
    protected $signature = 'db:export-json';
    protected $description = 'Export all SQLite tables to JSON';

    public function handle()
    {
        // Get all tables from SQLite
        $tables = DB::connection('sqlite')->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT IN ('sqlite_sequence', 'migrations')");
        
        $exportData = [];
        
        foreach ($tables as $tableInfo) {
            $tableName = $tableInfo->name;
            $this->info("Exporting table: " . $tableName);
            
            // Get all rows
            $exportData[$tableName] = DB::connection('sqlite')->table($tableName)->get()->toArray();
        }
        
        Storage::put('data_backup.json', json_encode($exportData, JSON_PRETTY_PRINT));
        $this->info('Export successful! Saved to storage/app/data_backup.json');
    }
}
