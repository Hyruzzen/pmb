<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramStudi extends Model
{
    protected $table = 'program_studis';

    protected $fillable = [
        'fakultas_id',
        'nama_prodi',
    ];

    /**
     * Relasi: Program Studi milik satu Fakultas
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }
}
