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
    Schema::create('pendaftaran_prodis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pendaftaran_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('fakultas_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('program_studi_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('pendaftaran_prodis');
}

};
