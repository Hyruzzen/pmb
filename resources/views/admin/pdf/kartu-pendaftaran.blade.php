<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Bukti Pendaftaran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            
        }
        td {
            padding: 6px;
            vertical-align: top;
        }
        .label {
            width: 35%;
        }
        .box {
            border: 1px solid #000;
            padding: 15px;
            margin-top: 10px;
        }
        .qr {
            text-align: center;
            margin-top: 25px;
        }
        .foto-box {
            width: 100px;
            height: 130px;
            border: 1px solid #000;
            text-align: center;
            line-height: 130px;
            font-size: 11px;
        }
        .header-table {
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- HEADER + FOTO -->
<table class="header-table">
    <tr>
        <td width="70%">
            <h3>PENERIMAAN MAHASISWA BARU</h3>
            <strong>KARTU BUKTI PENDAFTARAN</strong>
        </td>
        
    </tr>
</table>

<!-- DATA PENDAFTARAN -->
<div class="box">
    <table>
        <tr>
            <!-- DATA -->
            <td width="70%">
                <table>
                    <tr>
                        <td class="label"><strong>No Pendaftaran</strong></td>
                        <td>: {{ $noDaftar }}</td>
                    </tr>
                    <tr>
                        <td class="label"><strong>Nama Lengkap</strong></td>
                        <td>: {{ $pendaftaran->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="label"><strong>Fakultas</strong></td>
                        <td>: {{ $pendaftaran->fakultas->nama_fakultas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label"><strong>Program Studi</strong></td>
                        <td>: {{ $pendaftaran->programStudi->nama_prodi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label"><strong>Tanggal Cetak</strong></td>
                        <td>: {{ now()->format('d-m-Y') }}</td>
                    </tr>
                </table>
            </td>

            <!-- FOTO -->
            <td width="30%" align="center">
                <div class="foto-box">
                    @if($foto)
                        <img src="{{ $foto }}" width="100" height="130">
                    @else
                        FOTO
                    @endif
                </div>
            </td>
        </tr>
    </table>
</div>


<!-- QR CODE -->
<div class="qr">
    <p><strong>Scan QR Code</strong></p>
    <img src="data:image/svg+xml;base64,{{ $qr }}">
</div>

</body>
</html>
