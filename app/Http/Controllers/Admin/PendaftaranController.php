<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

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
        $pendaftaran->delete();
        return redirect()->route('admin.pendaftaran.index')->with('success','Deleted');
    }
}
