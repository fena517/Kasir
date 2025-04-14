@extends('layout.template')

@section('content')
<div class="container">
    <h2>Pembayaran #{{ $penjualan->PenjualanId }}</h2>

    <!-- Informasi Penjualan -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Detail Penjualan</h5>
            <p><strong>Tanggal Penjualan:</strong> {{ date('d-m-Y', strtotime($penjualan->TanggalPenjualan)) }}</p>
            <p><strong>Pelanggan:</strong> {{ $penjualan->pelanggan->NamaPelanggan }}</p>
            
            <h6 class="mt-3">Rincian Pembelian:</h6>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Nama Produk</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->details as $detail)
                        <tr>
                            <td>{{ optional($detail->produk)->NamaProduk ?? 'Produk Tidak Ditemukan' }}</td>
                            <td class="text-center">{{ $detail->JumlahProduk }}</td>
                            <td class="text-end">Rp {{ number_format($detail->Harga ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format(($detail->JumlahProduk * ($detail->Harga ?? 0)), 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>                
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total Harga:</th>
                        <th class="text-end">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Form Pembayaran -->
    <form action="{{ route('pembayaran.store') }}" method="POST">
        @csrf
        <input type="hidden" name="PenjualanId" value="{{ $penjualan->PenjualanId }}">
        <div class="mb-3">
            <label for="MetodePembayaran" class="form-label">Metode Pembayaran</label>
            <select class="form-control" id="MetodePembayaran" name="MetodePembayaran" required>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
                <option value="QRIS">QRIS</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="TotalDibayar" class="form-label">Total Dibayar</label>
            <input type="number" class="form-control" id="TotalDibayar" name="TotalDibayar" required>
        </div>

        <div class="mb-3">
            <label for="Kembalian" class="form-label">Kembalian</label>
            <input type="text" class="form-control" id="Kembalian" readonly>
        </div>

        <button type="submit" class="btn btn-primary w-100" id="bayarBtn" disabled>Bayar</button>
    </form>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log("Script Loaded!");

    const jumlahDibayarkanInput = document.getElementById('TotalDibayar');
    const kembalianInput = document.getElementById('Kembalian');
    const bayarBtn = document.getElementById('bayarBtn');
    const totalHarga = {{ $penjualan->TotalHarga }}; // Tidak perlu parseInt karena sudah angka

    console.log("Total Harga:", totalHarga);

    function formatRupiah(angka) {
        return "Rp " + angka.toLocaleString('id-ID');
    }

    jumlahDibayarkanInput.addEventListener('input', function () {
        let jumlahDibayarkan = parseInt(this.value) || 0;
        let kembalian = jumlahDibayarkan - totalHarga;
        
        kembalianInput.value = kembalian < 0 ? "Pembayaran kurang!" : formatRupiah(kembalian);
        console.log("Jumlah Dibayarkan:", jumlahDibayarkan);
        console.log("Kembalian:", kembalian);

        // Jika jumlah cukup, aktifkan tombol bayar
        bayarBtn.disabled = jumlahDibayarkan < totalHarga;
    });
});
</script>
@endsection
