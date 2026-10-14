<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px 8px; text-align: left; }
        th { background: #eee; }
        h3, p { margin: 0 0 8px; }
    </style>
</head>
<body>
    <h3>Laporan Keuangan - Inovindo Digital Media</h3>
    <p>Periode: {{ \Carbon\Carbon::parse($dari)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Proyek</th>
                <th>Jumlah (Rp)</th>
                <th>Tipe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $t)
                <tr>
                    <td>{{ $t->tanggal->format('d-m-Y') }}</td>
                    <td>{{ $t->kategori->nama_kategori }}</td>
                    <td>{{ ucfirst($t->kategori->jenis) }}</td>
                    <td>{{ $t->proyek->nama_proyek ?? '-' }}</td>
                    <td>{{ number_format($t->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $t->tipe === 'recurring' ? 'Recurring' : 'One-time' }}</td>
                </tr>
            @endforeach
                </tbody>
    </table>

    <table style="margin-top: 15px; width: 300px; margin-left: auto;">
        <tr>
            <td><strong>Total Pemasukan</strong></td>
            <td style="text-align: right;">Rp {{ number_format($total['pemasukan'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Pengeluaran</strong></td>
            <td style="text-align: right;">Rp {{ number_format($total['pengeluaran'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Selisih (Laba/Rugi)</strong></td>
            <td style="text-align: right; font-weight: bold;">Rp {{ number_format($total['selisih'], 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>