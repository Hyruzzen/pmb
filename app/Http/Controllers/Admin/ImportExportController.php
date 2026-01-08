<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Pendaftaran;

class ImportExportController extends Controller
{
    public function exportCsv()
    {
        $filename = 'pendaftaran_export_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $columns = ['id','nama_lengkap','nik','email','no_hp','tempat_lahir','tanggal_lahir','jenis_kelamin','alamat','fakultas','program_studi','status_pendaftaran'];

        $callback = function () use ($columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            Pendaftaran::with('user','fakultas','programStudi')->orderBy('id')->chunk(200, function($rows) use ($handle) {
                foreach ($rows as $r) {
                    fputcsv($handle, [
                        $r->id,
                        $r->nama_lengkap,
                        $r->nik,
                        $r->user?->email ?? '',
                        $r->no_hp,
                        $r->tempat_lahir,
                        $r->tanggal_lahir,
                        $r->jenis_kelamin,
                        $r->alamat,
                        $r->fakultas?->nama_fakultas ?? '',
                        $r->programStudi?->nama_prodi ?? '',
                        $r->status_pendaftaran,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if ($handle === false) {
            return back()->with('error', 'Gagal membuka file.');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            return back()->with('error', 'File CSV kosong atau tidak valid.');
        }

        $expected = ['id','nama_lengkap','nik','email','no_hp','tempat_lahir','tanggal_lahir','jenis_kelamin','alamat','fakultas','program_studi','status_pendaftaran'];

        // allow files with or without id column; we just require email and nama_lengkap
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            $data = array_combine($header, $row);
            if ($data === false) {
                $errors[] = "Baris {$rowNumber}: kolom tidak cocok.";
                continue;
            }

            $validator = Validator::make($data, [
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'nik' => 'nullable|string|max:50',
                'no_hp' => 'nullable|string|max:30',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'nullable|string',
                'status_pendaftaran' => 'nullable|in:data_diri,prodi,berkas,selesai',
            ]);

            if ($validator->fails()) {
                $errors[] = "Baris {$rowNumber}: " . implode('; ', $validator->errors()->all());
                continue;
            }

            // find or create user
            $user = User::where('email', $data['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $data['nama_lengkap'],
                    'email' => $data['email'],
                    'password' => Hash::make(Str::random(12)),
                    'role' => 'calon',
                    'status_pendaftaran' => $data['status_pendaftaran'] ?? 'data_diri',
                ]);
            } else {
                $user->update([
                    'name' => $data['nama_lengkap'],
                    'status_pendaftaran' => $data['status_pendaftaran'] ?? $user->status_pendaftaran,
                ]);
            }

            // create or update pendaftaran
            $pendaftaran = Pendaftaran::firstOrNew(['user_id' => $user->id]);
            $pendaftaran->nama_lengkap = $data['nama_lengkap'];
            $pendaftaran->nik = $data['nik'] ?? $pendaftaran->nik;
            $pendaftaran->no_hp = $data['no_hp'] ?? $pendaftaran->no_hp;
            $pendaftaran->tempat_lahir = $data['tempat_lahir'] ?? $pendaftaran->tempat_lahir;
            $pendaftaran->tanggal_lahir = $data['tanggal_lahir'] ?? $pendaftaran->tanggal_lahir;
            $pendaftaran->jenis_kelamin = $data['jenis_kelamin'] ?? $pendaftaran->jenis_kelamin;
            $pendaftaran->alamat = $data['alamat'] ?? $pendaftaran->alamat;
            $pendaftaran->status_pendaftaran = $data['status_pendaftaran'] ?? $pendaftaran->status_pendaftaran ?? 'data_diri';
            $pendaftaran->save();
        }

        fclose($handle);

        if (!empty($errors)) {
            return back()->with('import_errors', $errors)->with('success', 'Impor selesai dengan beberapa peringatan.');
        }

        return back()->with('success', 'Impor berhasil.');
    }
}
