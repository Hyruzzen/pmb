<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftarans', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('no_hp');
            }
            if (!Schema::hasColumn('pendaftarans', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }
            if (!Schema::hasColumn('pendaftarans', 'jenis_kelamin')) {
                $table->string('jenis_kelamin')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('pendaftarans', 'alamat')) {
                $table->text('alamat')->nullable()->after('jenis_kelamin');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftarans', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('pendaftarans', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }
            if (Schema::hasColumn('pendaftarans', 'tanggal_lahir')) {
                $table->dropColumn('tanggal_lahir');
            }
            if (Schema::hasColumn('pendaftarans', 'tempat_lahir')) {
                $table->dropColumn('tempat_lahir');
            }
        });
    }
};
