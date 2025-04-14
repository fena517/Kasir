@extends('layout.template')

@section('content')
<div class="container">
    <h2 class="mb-4">Lihat Laporan Penjualan</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal Penjualan</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualans as $penjualan)
                <tr>
                    <td>{{ $penjualan->TanggalPenjualan }}</td>
                    <td>{{ $penjualan->pelanggan->nama ?? 'Umum' }}</td>
                    <td>Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $penjualan->pembayaran->status ?? 'Belum Dibayar' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
