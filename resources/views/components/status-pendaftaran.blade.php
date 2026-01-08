<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
</div>
@php
$status = Auth::user()->status_pendaftaran;

$label = match($status) {
    'baru' => 'Akun Terdaftar',
    'data_diri' => 'Data Diri Terisi',
    'prodi' => 'Program Studi Dipilih',
    'berkas' => 'Berkas Diunggah',
    'selesai' => 'Pendaftaran Selesai',
    default => 'Belum Lengkap',
};

$warna = match($status) {
    'baru' => 'bg-gray-200 text-gray-800',
    'data_diri' => 'bg-blue-100 text-blue-800',
    'prodi' => 'bg-indigo-100 text-indigo-800',
    'berkas' => 'bg-yellow-100 text-yellow-800',
    'selesai' => 'bg-green-100 text-green-800',
};
@endphp

<span class="inline-block px-4 py-1 rounded-full text-sm font-semibold {{ $warna }}">
    Status: {{ $label }}
</span>