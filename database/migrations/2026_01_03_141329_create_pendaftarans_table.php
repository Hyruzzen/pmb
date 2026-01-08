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
    Schema::create('pendaftarans', function (Blueprint $table) {
    $table->id();

    $table->index('user_id');
    $table->index('fakultas_id');
    $table->index('program_studi_id');


    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    // STEP 1 – DATA DIRI
    $table->string('nama_lengkap');
    $table->string('nik');
    $table->string('no_hp')->nullable();

    // STEP 2 – PRODI
    $table->foreignId('fakultas_id')
          ->nullable()
          ->constrained('fakultas');

    $table->foreignId('program_studi_id')
          ->nullable()
          ->constrained('program_studis');

    // STEP 3 – BERKAS
    $table->string('file_ktp')->nullable();
    $table->string('file_ijazah')->nullable();
    $table->string('pas_foto')->nullable();

    // STATUS PROSES
    $table->enum('status_pendaftaran', [
        'data_diri',
        'prodi',
        'berkas',
        'selesai'
    ])->default('data_diri');

    $table->timestamps();
});

}

public function down(): void
{
    Schema::dropIfExists('pendaftarans');
}

};
