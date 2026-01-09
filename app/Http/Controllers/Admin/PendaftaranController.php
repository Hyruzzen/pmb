<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class PendaftaranController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function data()
    {
        $rows = Pendaftaran::with('user','fakultas','programStudi')->orderBy('created_at','desc')->get();
        return response()->json($rows);
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('admin.show', compact('pendaftaran'));
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        return view('admin.edit', compact('pendaftaran'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'no_hp' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
        ]);

        $pendaftaran->update($request->only(['nama_lengkap','nik','no_hp','tempat_lahir','tanggal_lahir','alamat']));

        return redirect()->route('admin.pendaftaran.index')->with('success','Data updated');
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        // Reset status user sebelum delete
        if ($pendaftaran->user) {
            $pendaftaran->user->update([
                'status_pendaftaran' => 'baru'
            ]);
        }
        
        $pendaftaran->delete();
        return redirect()->route('admin.pendaftaran.index')->with('success','Deleted');
    }
public function cetakKartu(Pendaftaran $pendaftaran)
{
    // WAJIB
    $pendaftaran->load(['fakultas', 'programStudi']);

    $noDaftar = 'PMB-' . str_pad($pendaftaran->id, 6, '0', STR_PAD_LEFT);

    $qr = base64_encode(
        QrCode::format('svg')
            ->size(120)
            ->generate($noDaftar)
    );

    // FOTO MAHASISWA (BASE64)
    $fotoBase64 = null;

    if ($pendaftaran->pas_foto) {
        $fullPath = public_path('storage/' . $pendaftaran->pas_foto);

        if (file_exists($fullPath)) {
            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
            $data = file_get_contents($fullPath);
            $fotoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    }

    // Generate PDF
    $pdf = Pdf::loadView('admin.pdf.kartu-pendaftaran', [
        'pendaftaran' => $pendaftaran,
        'noDaftar'    => $noDaftar,
        'qr'          => $qr,
        'foto'        => $fotoBase64,
    ]);

    return $pdf->download('Kartu-PMB-' . $pendaftaran->nama_lengkap . '.pdf');
}

}
