<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('area_id')->constrained()->restrictOnDelete();
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('judul');
            $table->text('kondisi');
            $table->string('tingkat')->default('ringan'); 
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->dateTime('waktu_kejadian');

            $table->string('status')->default('baru'); 
            $table->text('catatan_relawan')->nullable();
            $table->string('diteruskan_ke')->nullable();
            $table->dateTime('diteruskan_pada')->nullable();
            $table->string('evidence_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
