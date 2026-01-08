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
    Schema::table('pendaftarans', function (Blueprint $table) {

        if (!Schema::hasColumn('pendaftarans', 'tempat_lahir')) {
            $table->string('tempat_lahir')->nullable()->after('no_hp');
        }

        if (!Schema::hasColumn('pendaftarans', 'tanggal_lahir')) {
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
        }

        if (!Schema::hasColumn('pendaftarans', 'alamat')) {
            $table->text('alamat')->nullable()->after('tanggal_lahir');
        }

    });
}

public function down(): void
{
    Schema::table('pendaftarans', function (Blueprint $table) {
        $table->dropColumn(['tempat_lahir', 'tanggal_lahir', 'alamat']);
    });
}


};
