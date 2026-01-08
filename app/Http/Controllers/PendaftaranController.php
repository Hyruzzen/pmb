<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:pendaftarans,nik,' . optional($user->pendaftaran)->id,
            'no_hp' => 'required|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::info('Pendaftaran: validasi data diri gagal', [
                'user_id' => optional($user)->id,
                'input' => $request->only(['nama_lengkap', 'nik', 'no_hp']),
                'errors' => $validator->errors()->toArray(),
            ]);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // create atau update (AMAN UNTUK MULTI STEP)
            Pendaftaran::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_lengkap' => $request->nama_lengkap,
                    'nik'          => $request->nik,
                    'no_hp'        => $request->no_hp,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'status_pendaftaran' => 'data_diri',
                ]
            );

            // update status di user
            $user->update([
                'status_pendaftaran' => 'data_diri',
            ]);

            return redirect()->route('pendaftaran.prodi');

        } catch (\Throwable $e) {
            Log::error('Pendaftaran: gagal menyimpan data diri', [
                'user_id' => optional($user)->id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Coba lagi atau hubungi admin.');
        }
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

        // ambil daftar fakultas beserta prodi
        $fakultas = \App\Models\Fakultas::with('programStudis')->get();

        return view('pendaftaran.prodi', compact('fakultas'));
    }

    public function storeProdi(Request $request)
    {
        $user = Auth::user();

        // Accept either integer IDs (normal flow) or string names (fallback when DB is empty)
        $request->validate([
            'fakultas' => 'required',
            'prodi'    => 'required',
        ]);

        $pendaftaran = $user->pendaftaran;

        if (!$pendaftaran) {
            return redirect()->route('pendaftaran.create');
        }


        // Determine Fakultas ID and ProgramStudi ID. If DB has records, posted values should be IDs.
        try {
            $fakultasId = null;
            $prodiId = null;

            // if posted fakultas is numeric and exists, use it
            if (is_numeric($request->fakultas) && \App\Models\Fakultas::where('id', $request->fakultas)->exists()) {
                $fakultasId = (int) $request->fakultas;
            } else {
                // create or find by name (fallback)
                $f = \App\Models\Fakultas::firstOrCreate([
                    'nama_fakultas' => $request->fakultas,
                ]);
                $fakultasId = $f->id;
            }

            // program studi: if numeric and exists, use it
            if (is_numeric($request->prodi) && \App\Models\ProgramStudi::where('id', $request->prodi)->exists()) {
                $prodiId = (int) $request->prodi;
            } else {
                // create or find by name under the fakultas
                $p = \App\Models\ProgramStudi::firstOrCreate([
                    'fakultas_id' => $fakultasId,
                    'nama_prodi' => $request->prodi,
                ]);
                $prodiId = $p->id;
            }

            $pendaftaran->update([
                'fakultas_id'       => $fakultasId,
                'program_studi_id' => $prodiId,
            ]);

        } catch (\Throwable $e) {
            Log::error('Pendaftaran: gagal menyimpan prodi', [
                'user_id' => optional($user)->id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pilihan Program Studi.');
        }

        $pendaftaran->update(['status_pendaftaran' => 'prodi']);
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
            'file_ktp'    => $request->file('ktp')->store('berkas/ktp', 'public'),
            'file_ijazah' => $request->file('ijazah')->store('berkas/ijazah', 'public'),
            'pas_foto'    => $request->file('pas_foto')->store('berkas/pas_foto', 'public'),
            'status_pendaftaran' => 'berkas',
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

        $pendaftaran = $user->pendaftaran;
        if ($pendaftaran) {
            $pendaftaran->update([
                'status_pendaftaran' => 'selesai',
            ]);
        }
        
        $user->update([
            'status_pendaftaran' => 'selesai',
        ]);

        return view('pendaftaran.selesai');
    }
}
