@extends('layout.template')

@section('content')
<div class="modal fade show d-block" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Struk Pembayaran</h5>
                <button type="button" class="btn-close" onclick="redirectToIndex()"></button>
            </div>
            <div class="modal-body text-center">
                <h5 class="fw-bold mb-0">Win's Delight Cafe</h5>
                <small class="text-muted">Jl. Contoh No. 123, Kota Anda</small>
                <hr>
                <table class="w-100 mb-2">
                    <tr>
                        <td class="text-start">No. Transaksi</td>
                        <td class="text-end fw-bold">{{ $pembayaran->KodeTransaksi }}</td>
                    </tr>
                    <tr>
                        <td class="text-start">Tanggal</td>
                        <td class="text-end fw-bold">{{ date('d-m-Y H:i', strtotime($pembayaran->created_at)) }}</td>
                    </tr>
                    <tr>
                        <td class="text-start">Metode Pembayaran</td>
                        <td class="text-end fw-bold">{{ $pembayaran->MetodePembayaran }}</td>
                    </tr>
                </table>
                <hr>
                <table class="table table-sm text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">Nama Produk</th>
                            <th>Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalHarga = 0; @endphp
                        @foreach($pembayaran->penjualan->details as $detail)
                            @php 
                                $hargaSatuan = $detail->Harga;
                                $subtotal = $detail->JumlahProduk * $hargaSatuan;
                                $totalHarga += $subtotal;
                            @endphp
                            <tr>
                                <td class="text-start">{{ $detail->produk->NamaProduk ?? 'Produk Tidak Ditemukan' }}</td>
                                <td>{{ $detail->JumlahProduk }}</td>
                                <td class="text-end">Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <table class="w-100 mb-3">
                    <tr>
                        <td class="text-start fw-bold">Total Harga</td>
                        <td class="text-end fw-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Jumlah Dibayarkan</td>
                        <td class="text-end fw-bold">Rp {{ number_format($pembayaran->TotalDibayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Kembalian</td>
                        <td class="text-end fw-bold">Rp {{ number_format($pembayaran->Kembalian, 0, ',', '.') }}</td>
                    </tr>
                </table>
                <p class="mt-2 mb-0">Terima kasih telah berbelanja!</p>
                <small class="text-muted">Semoga harimu menyenangkan :)</small>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="redirectToIndex()">Tutup</button>
                <button type="button" class="btn btn-success" onclick="printStruk()">Print Struk</button>
            </div>
        </div>
    </div>
</div>

<script>
    function printStruk() {
        var printContents = document.querySelector(".modal-content").cloneNode(true);
        printContents.querySelector(".modal-footer").remove();
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents.innerHTML;
        window.print();
        document.body.innerHTML = originalContents;
    }

    function redirectToIndex() {
        window.location.href = "{{ route('penjualans.index') }}";
    }
</script>
@endsection