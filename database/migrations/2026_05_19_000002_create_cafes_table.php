<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cafes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('kemantren')->nullable();
            $table->string('konsep_utama')->nullable();
            $table->string('gmaps_url')->nullable();
            $table->string('open_time')->default('08:00');
            $table->string('close_time')->default('22:00');
            $table->integer('avg_price')->default(0);
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cafes');
    }
};
