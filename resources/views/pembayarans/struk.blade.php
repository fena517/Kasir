@extends('layout.template')

@section('content')
<div class="container d-flex justify-content-center mt-4">
    <div class="receipt border p-3" style="width: 300px; font-family: monospace; font-size: 12px; background-color: white; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15); border-radius: 8px;">
        <div class="text-center mb-2">
            <img src="{{ asset('assets/img/logo kasir.png') }}" alt="Logo" style="height: 50px;"><br>
            <strong>Win'z Mart</strong><br>
            <small>Jl. NIeng No.24, Depok</small>
            <small>WA: 0857-3456-7890</small>
        </div>
        <hr style="border-top: 1px dashed #000;">
        <div class="mb-2">
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="width: 40%;">No. Transaksi</td>
                    <td style="width: 5%;">:</td>
                    <td>{{ $pembayaran->KodeTransaksi }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ date('d-m-Y H:i', strtotime($pembayaran->created_at)) }}</td>
                </tr>
                <tr>
                    <td>Metode Bayar</td>
                    <td>:</td>
                    <td>{{ $pembayaran->MetodePembayaran }}</td>
                </tr>
            </table>
        </div>
        <hr style="border-top: 1px dashed #000;">
        <div>
            <div class="d-flex fw-bold border-bottom pb-1 mb-1">
                <div style="width: 40%;">Produk</div>
                <div style="width: 15%;">Qty</div>
                <div style="width: 20%;">Harga</div>
                <div style="width: 25%;" class="text-end">Subtotal</div>
            </div>
            @php $totalHarga = 0; @endphp
            @foreach($pembayaran->penjualan->details as $detail)
                @php 
                    $hargaSatuan = $detail->Harga;
                    $subtotal = $detail->JumlahProduk * $hargaSatuan;
                    $totalHarga += $subtotal;
                @endphp
                <div class="d-flex">
                    <div style="width: 40%;">{{ $detail->produk->NamaProduk ?? 'Tidak Ditemukan' }}</div>
                    <div style="width: 15%;">{{ $detail->JumlahProduk }}</div>
                    <div style="width: 20%;">Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</div>
                    <div style="width: 25%;" class="text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>
        <hr style="border-top: 1px dashed #000;">
        <div>
            <table style="width: 100%; font-size: 12px;">
                <tr>
                    <td style="width: 25%; text-align: left;">Total</td>
                    <td style="width: 5%; text-align: center;">:</td>
                    <td style="text-align: right;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Dibayar</td>
                    <td style="text-align: center;">:</td>
                    <td style="text-align: right;">Rp {{ number_format($pembayaran->TotalDibayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Kembalian</td>
                    <td style="text-align: center;">:</td>
                    <td style="text-align: right;">Rp {{ number_format($pembayaran->Kembalian, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <hr style="border-top: 1px dashed #000;">
        <div class="text-center mt-2">
            <p>*** Terima kasih ***</p>
            <small>Semoga harimu menyenangkan :)</small>
        </div>
        <div class="mt-3 text-center">
            <button class="btn btn-sm btn-success" onclick="printStruk()">Print</button>
            <button class="btn btn-sm btn-secondary" onclick="redirectToIndex()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function printStruk() {
        var printContents = document.querySelector(".receipt").cloneNode(true);
        document.body.innerHTML = '';
        document.body.appendChild(printContents);
        window.print();
        window.location.reload();
    }

    function redirectToIndex() {
        window.location.href = "{{ route('penjualans.index') }}";
    }
</script>
@endsection