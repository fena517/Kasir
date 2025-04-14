@extends('layout.template')
@section('content')
    <div class="container form-container mt-3"> <!-- Reduced margin-top here -->
        <div class="card">
            <div class="card-header py-3">
                <h2 class="mb-0">Tambah Produk</h2>
            </div>
            <div class="card-body p-4">
            <form action="{{ route('produks.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="KodeProduk" class="form-label">Kode Produk</label>
                            <input type="text" name="KodeProduk" id="KodeProduk" class="form-control" placeholder="Masukkan kode produk" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="NamaProduk" class="form-label">Nama Produk</label>
                            <input type="text" name="NamaProduk" id="NamaProduk" class="form-control" placeholder="Masukkan nama produk" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="KategoriId" class="form-label">Kategori</label>
                            <select name="KategoriId" id="KategoriId" class="form-control" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->KategoriId }}">{{ $kategori->Nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="UnitId" class="form-label">Unit</label>
                            <select name="UnitId" id="UnitId" class="form-control" required>
                                <option value="" selected disabled>Pilih Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->UnitId }}">{{ $unit->Nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="Harga" class="form-label">Harga</label>
                            <input type="text" name="Harga" id="Harga" class="form-control" placeholder="Harga" value="{{ isset($produk) ? number_format($produk->Harga, 2, ',', '.') : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="namber" name="stok" id="stok" class="form-control" placeholder="stok" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-maroon me-2">Simpan</button>
                        <a href="{{ route('produks.index') }}" class="btn btn-outline-secondary">Keluar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

    document.querySelector('form').addEventListener('submit', function () {
        let hargaInput = document.getElementById('Harga');
        hargaInput.value = hargaInput.value.replace(/\./g, ''); // Hapus titik sebelum dikirim
    });
    </script>    
@endsection