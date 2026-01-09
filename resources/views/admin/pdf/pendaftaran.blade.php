<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PMB</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #eee;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <h3>PMB ONLINE</h3>
    <p>Laporan Data Pendaftar</p>
    <small>Tanggal Cetak: {{ now()->format('d-m-Y') }}</small>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>NIK</th>
            <th>JK</th>
            <th>Fakultas</th>
            <th>Program Studi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pendaftarans as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->jenis_kelamin }}</td>
            <td>{{ $item->fakultas->nama ?? '-' }}</td>
            <td>{{ $item->programStudi->nama ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
