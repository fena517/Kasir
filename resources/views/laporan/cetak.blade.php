<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table, .table th, .table td { border: 1px solid black; }
        .table th, .table td { padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
    <h2 align="center">Laporan Penjualan</h2>
    <p align="center">Periode: {{ $tanggalMulai->format('d-m-Y') }} sampai {{ $tanggalSelesai->format('d-m-Y') }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @php $totalKeseluruhan = 0; @endphp
            @foreach($penjualans as $key => $penjualan)
                @foreach($penjualan->details as $index => $detail)
                <tr>
                    @if($index === 0)
                        <td rowspan="{{ count($penjualan->details) }}">{{ $key + 1 }}</td>
                        <td rowspan="{{ count($penjualan->details) }}">{{ $penjualan->TanggalPenjualan }}</td>
                        <td rowspan="{{ count($penjualan->details) }}">{{ $penjualan->pelanggan->NamaPelanggan ?? 'Umum' }}</td>
                    @endif
                    <td>{{ $detail->produk->NamaProduk ?? '-' }}</td>
                    <td>{{ $detail->JumlahProduk }}</td>
                    <td>Rp {{ number_format($detail->Harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->SubTotal, 0, ',', '.') }}</td>
                    @if($index === 0)
                        <td rowspan="{{ count($penjualan->details) }}">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                        <td rowspan="{{ count($penjualan->details) }}">{{ $penjualan->pembayaran->MetodePembayaran ?? '-' }}</td>
                    @endif
                </tr>
                @endforeach
                @php $totalKeseluruhan += $penjualan->TotalHarga; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="7" class="text-right">Total Keseluruhan:</td>
                <td colspan="2">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
