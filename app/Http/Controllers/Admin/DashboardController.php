<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    // 👇 INI PENGGANTI SQL YANG KAMU TANYA
    public function chartData()
{
    $data = \App\Models\ProgramStudi::leftJoin(
            'pendaftarans',
            'program_studis.id',
            '=',
            'pendaftarans.program_studi_id'
        )
        ->select(
            'program_studis.nama_prodi',
            \DB::raw('COUNT(pendaftarans.id) as total')
        )
        ->groupBy('program_studis.id', 'program_studis.nama_prodi')
        ->get();

    return response()->json($data);
}

    public function genderChart()
{
    $gender = \App\Models\Pendaftaran::select(
            'jenis_kelamin',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('jenis_kelamin')
        ->get();

    return response()->json($gender);
}
}
