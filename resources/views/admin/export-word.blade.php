<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendaftaran Ekstrakurikuler</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; }
        h2, h4 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; font-size: 11pt; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h2>PEMERINTAH PROVINSI DKI JAKARTA</h2>
    <h2>DINAS PENDIDIKAN</h2>
    <h2>SMKN 20 JAKARTA</h2>
    <h4>LAPORAN DATA PENDAFTARAN EKSTRAKURIKULER</h4>
    <p class="text-center" style="font-size: 10pt; margin-bottom: 20px;">Tahun Ajaran 2025/2026</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th>Nama Siswa</th>
                <th>Email Sekolah</th>
                <th>Ekstrakurikuler</th>
                <th>Hari</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td>{{ $p->user->email ?? '-' }}</td>
                    <td>{{ $p->ekstrakurikuler->nama_ekskul ?? '-' }}</td>
                    <td>{{ $p->ekstrakurikuler->hari ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst($p->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>