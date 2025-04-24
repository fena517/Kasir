@extends('layout.template')

@section('content')
<div class="container d-flex justify-content-center mt-4">
    <div class="receipt border p-3" style="width: 300px; font-family: monospace; font-size: 12px; background-color: white; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15); border-radius: 8px;">
        <div class="text-center mb-2">
            <img src="{{ asset('assets/img/logo kasir.png') }}" alt="Logo" style="height: 50px;"><br>
            <strong>Win'z Mart</strong><br>
            <small>Jl. Nieng No.24, Depok</small><br>
        </div>
        <hr style="border-top: 1px dashed #000;">
        <table style="width: 100%; font-size: 12px;" class="mb-2">
            <tr>
                <td style="width: 40%;">No. Transaksi</td>
                <td style="width: 5%;">:</td>
                <td>{{ $pembayaran->KodeTransaksi }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($pembayaran->created_at)->translatedFormat('d-m-Y') }}</td>
            </tr>
            <tr>
                <td>Metode Bayar</td>
                <td>:</td>
                <td>{{ $pembayaran->MetodePembayaran }}</td>
            </tr>
        </table>
        <hr style="border-top: 1px dashed #000;">
        <table style="width: 100%; font-size: 12px;" class="mb-2">
            <thead>
                <tr class="fw-bold border-bottom">
                    <td style="width: 40%;">Produk</td>
                    <td style="width: 15%; text-align: center;">Qty</td>
                    <td style="width: 20%; text-align: right;">Harga</td>
                    <td style="width: 25%; text-align: right;">Total</td>
                </tr>
            </thead>
            <tbody>
                @php $totalHarga = 0; @endphp
                @foreach($pembayaran->penjualan->details as $detail)
                    @php 
                        $subtotal = $detail->JumlahProduk * $detail->Harga;
                        $totalHarga += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $detail->produk->NamaProduk ?? 'Produk Tidak Ditemukan' }}</td>
                        <td style="text-align: center;">{{ $detail->JumlahProduk }}</td>
                        <td style="text-align: right;">Rp {{ number_format($detail->Harga, 0, ',', '.') }}</td>
                        <td style="text-align: right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr style="border-top: 1px dashed #000;">
        <table style="width: 100%; font-size: 12px;" class="mb-2">
            <tr>
                <td>Total Bayar</td>
                <td>:</td>
                <td style="text-align: right;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunai</td>
                <td>:</td>
                <td style="text-align: right;">Rp {{ number_format($pembayaran->TotalDibayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td>:</td>
                <td style="text-align: right;">Rp {{ number_format($pembayaran->Kembalian, 0, ',', '.') }}</td>
            </tr>
        </table>
        <hr style="border-top: 1px dashed #000;">
        <div class="text-center">
            <p>~ Terima kasih atas kunjungannya ~</p>
        </div>
        <div class="text-center d-print-none">
            <button onclick="window.print()" class="btn btn-success btn-sm me-2">Print</button>
            <button onclick="window.location.href='{{ route('penjualans.index') }}'" class="btn btn-primary btn-sm">Tutup</button>
        </div>
    </div>
</div>
@endsection
