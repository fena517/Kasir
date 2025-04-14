@extends('layout.template')
@section('content')
<div class="container">
    <div class="container form-container mt-3"> <!-- Reduced margin-top here -->
        <div class="card">
            <div class="card-header py-3">
                <h2 class="mb-0">Tambah Produk</h2>
            </div>
            <div class="card-body p-4">
            <form action="{{ route('stock_outs.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ProdukId" class="form-label">Produk</label>
                            <select name="ProdukId" id="ProdukId" class="form-control" required>
                                <option value="" selected disabled>Pilih Produk</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->ProdukId }}">{{ $produk->NamaProduk }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="Jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="Jumlah" id="Jumlah" class="form-control" placeholder="Jumlah" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Tgl" class="form-label">Tanggal</label>
                            <input type="date" name="Tgl" id="Tgl" class="form-control" placeholder="Tgl" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Alasan" class="form-label">Alasan</label>
                            <input type="text" name="Alasan" id="Alasan" class="form-control" placeholder="Alasan" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-maroon me-2">Simpan</button>
                        <a href="{{ route('stock_outs.index') }}" class="btn btn-outline-secondary">Keluar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const hargaInput = document.getElementById('Harga');
    
        hargaInput.addEventListener('input', function (e) {
            let value = e.target.value;
    
            // Hapus karakter selain angka
            value = value.replace(/[^0-9]/g, '');
    
            // Tambahkan format titik setiap ribuan
            value = new Intl.NumberFormat('id-ID').format(value);
    
            // Tampilkan hasil format
            e.target.value = value;
        });
    
        // Hilangkan titik sebelum form dikirim
        document.querySelector('form').addEventListener('submit', function () {
            hargaInput.value = hargaInput.value.replace(/\./g, '');
        });
    </script>    
@endsection