<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    /**
     * =========================
     * STEP 1 – DATA DIRI
     * =========================
     */
    public function create()
    {
        return view('pendaftaran.data-diri');
    }

    public function storeDataDiri(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:pendaftarans,nik,' . optional($user->pendaftaran)->id,
            'no_hp' => 'required|string|max:20',
        ]);

        // create atau update (AMAN UNTUK MULTI STEP)
        Pendaftaran::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_lengkap' => $request->nama_lengkap,
                'nik'          => $request->nik,
                'no_hp'        => $request->no_hp,
            ]
        );

        // update status
        $user->update([
            'status_pendaftaran' => 'data_diri',
        ]);

        return redirect()->route('pendaftaran.prodi');
    }

    /**
     * =========================
     * STEP 2 – PILIH PRODI
     * =========================
     */
    public function prodi()
    {
        $user = Auth::user();

        if ($user->status_pendaftaran !== 'data_diri') {
            return redirect()->route('pendaftaran.create');
        }

        return view('pendaftaran.prodi');
    }

    public function storeProdi(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fakultas' => 'required|integer',
            'prodi'    => 'required|integer',
        ]);

        $pendaftaran = $user->pendaftaran;

        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.create');
        }

        $pendaftaran->update([
            'fakultas_id'       => $request->fakultas,
            'program_studi_id' => $request->prodi,
        ]);

        $user->update([
            'status_pendaftaran' => 'prodi',
        ]);

        return redirect()->route('pendaftaran.upload')
            ->with('success', 'Program studi berhasil disimpan');
    }

    /**
     * =========================
     * STEP 3 – UPLOAD BERKAS
     * =========================
     */
    public function uploadBerkas()
    {
        $user = Auth::user();

        if ($user->status_pendaftaran !== 'prodi') {
            return redirect()->route('pendaftaran.prodi');
        }

        return view('pendaftaran.upload-berkas');
    }

    public function storeBerkas(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'ktp'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ijazah'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pas_foto' => 'required|image|max:2048',
        ]);

        $pendaftaran = $user->pendaftaran;

        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.create');
        }

        $pendaftaran->update([
            'file_ktp'    => $request->file('ktp')->store('berkas/ktp'),
            'file_ijazah' => $request->file('ijazah')->store('berkas/ijazah'),
            'pas_foto'    => $request->file('pas_foto')->store('berkas/pas_foto'),
        ]);

        $user->update([
            'status_pendaftaran' => 'berkas',
        ]);

        return redirect()->route('pendaftaran.selesai');
    }

    /**
     * =========================
     * STEP 4 – SELESAI
     * =========================
     */
    public function selesai()
    {
        $user = Auth::user();

        if ($user->status_pendaftaran !== 'berkas' &&
            $user->status_pendaftaran !== 'selesai') {
            return redirect()->route('dashboard');
        }

        $user->update([
            'status_pendaftaran' => 'selesai',
        ]);

        return view('pendaftaran.selesai');
    }
}
