<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KRS Mahasiswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        .header { text-align: center; }
    </style>
</head>
<body>

<div class="header">
    <h3>KARTU RENCANA STUDI (KRS)</h3>
    <p>PMB Online</p>
</div>

<table>
    <tr>
        <td><strong>Nama</strong></td>
        <td>{{ $pendaftaran->nama_lengkap }}</td>
    </tr>
    <tr>
        <td><strong>NIK</strong></td>
        <td>{{ $pendaftaran->nik }}</td>
    </tr>
    <tr>
        <td><strong>Fakultas</strong></td>
        <td>{{ $pendaftaran->fakultas->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td><strong>Program Studi</strong></td>
        <td>{{ $pendaftaran->programStudi->nama ?? '-' }}</td>
    </tr>
</table>

<h4>Daftar Mata Kuliah</h4>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($matkuls as $mk)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $mk['kode'] }}</td>
            <td>{{ $mk['nama'] }}</td>
            <td>{{ $mk['sks'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p style="margin-top:30px">
    Dicetak pada: {{ now()->format('d-m-Y') }}
</p>

</body>
</html>
