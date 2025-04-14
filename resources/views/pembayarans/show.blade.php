@extends('layout.template')

@section('content')
<style>
    .receipt {
        font-family: 'Courier New', Courier, monospace;
        width: 280px;
        margin: 30px auto;
        background-color: #fff;
        padding: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 12px;
        color: #000;
    }

    .receipt h5 {
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .receipt p {
        margin: 0;
        font-size: 11px;
    }

    .receipt hr {
        border-top: 1px dashed #aaa;
        margin: 8px 0;
    }

    .receipt .text-end {
        text-align: right;
    }

    .receipt .text-center {
        text-align: center;
    }

    .receipt .text-left {
        text-align: left;
    }

    .receipt .text-bold {
        font-weight: bold;
    }

    .receipt .btn-group {
        margin-top: 12px;
        display: flex;
        justify-content: space-between;
        gap: 8px;
    }

    .btn-print,
    .btn-close {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 4px;
        border: none;
    }

    .btn-print {
        background-color: #00b894;
        color: white;
    }

    .btn-close {
        background-color: #6c5ce7;
        color: white;
    }

    table.receipt-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.receipt-table th,
    table.receipt-table td {
        font-size: 11px;
        padding: 4px 2px;
        vertical-align: top;
        word-wrap: break-word;
    }

    table.receipt-table th {
        font-weight: bold;
        border-bottom: 1px solid #ccc;
    }

    .col-produk { width: 40%; }
    .col-qty { width: 10%; text-align: center; }
    .col-harga, .col-subtotal { width: 25%; text-align: right; }

    .info-kiri {
        text-align: left;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .info-kanan {
        text-align: right;
        font-size: 12px;
        margin-bottom: 4px;
    }

    @media print {
        .btn-group { display: none; }
        body { background: none; }
        .receipt { box-shadow: none; border: none; width: 100%; }
    }
</style>

<div class="modal fade show d-block" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content receipt">
            <div class="text-center">
                <h5>Win's Delight Cafe</h5>
                <p>Jl. Contoh No. 123, Kota Anda</p>
                <p>WA: 0812-3456-7890</p>
            </div>
            <hr>
            <div class="info-kiri">
                <div>No. Transaksi: {{ $pembayaran->KodeTransaksi }}</div>
                <div>
                    Tanggal: {{ \Carbon\Carbon::parse($pembayaran->created_at)->translatedFormat('d F Y') }} |
                    Pukul: {{ \Carbon\Carbon::parse($pembayaran->created_at)->format('H:i') }}
                </div>
                <div>Metode: {{ $pembayaran->MetodePembayaran }}</div>
            </div>
            <hr>
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th class="col-produk">PRODUK</th>
                        <th class="col-qty">QTY</th>
                        <th class="col-harga">HARGA</th>
                        <th class="col-subtotal">SUBTOTAL</th>
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
                            <td class="col-produk">{{ $detail->produk->NamaProduk ?? 'Produk Tidak Ditemukan' }}</td>
                            <td class="col-qty">{{ $detail->JumlahProduk }}</td>
                            <td class="col-harga">Rp {{ number_format($detail->Harga, 0, ',', '.') }}</td>
                            <td class="col-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <div class="info-kanan">
                <div>Total Bayar : Rp {{ number_format($totalHarga, 0, ',', '.') }}</div>
                <div>Tunai : Rp {{ number_format($pembayaran->TotalDibayar, 0, ',', '.') }}</div>
                <div>Kembalian : Rp {{ number_format($pembayaran->Kembalian, 0, ',', '.') }}</div>
            </div>
            <hr>
            <div class="text-center">
                <p>~ Terima kasih atas kunjungannya ~</p>
                <p>Follow IG: @winacafe.id</p>
            </div>
            <div class="btn-group">
                <button class="btn-close" onclick="redirectToIndex()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function printStruk() {
        window.print();
    }

    function redirectToIndex() {
        window.location.href = "{{ route('penjualans.index') }}";
    }
</script>
@endsection
