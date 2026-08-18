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
        Schema::create('lsu_rev', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('blok', 5);
            $table->string('estate', 45);
            $table->string('divisi', 5);
            $table->integer('tahun_tanam');
            $table->string('blok_tt', 25);
            $table->decimal('luas', 10, 2);
            $table->integer('pokok');
            $table->decimal('lsu', 10, 2);
            $table->string('unsur_hara', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lsu_rev');
    }
};
