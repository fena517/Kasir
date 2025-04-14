@extends('layout.template')
@section('content')
    <div class="container form-container mt-3"> <!-- Reduced margin-top here -->
        <div class="card">
            <div class="card-header py-3">
                <h2>Edit Produk</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('produks.update', $produk->ProdukId) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="KodeProduk" class="form-label">Kode Produk</label>
                        <input type="text" name="KodeProduk" class="form-control" value="{{ $produk->KodeProduk }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="NamaProduk" class="form-label">Nama Produk</label>
                        <input type="text" name="NamaProduk" class="form-control" value="{{ $produk->NamaProduk }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="KategoriId" class="form-label">Kategori</label>
                        <select name="KategoriId" class="form-control" required>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->KategoriId }}" {{ $kategori->KategoriId == $produk->KategoriId ? 'selected' : '' }}>
                                    {{ $kategori->Nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="UnitId" class="form-label">Satuan</label>
                        <select name="UnitId" class="form-control" required>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->UnitId }}" {{ $unit->UnitId == $produk->UnitId ? 'selected' : '' }}>
                                    {{ $unit->Nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Harga" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="Harga" name="Harga" value="{{ number_format($produk->Harga, 0, ',', '.') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('produks.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hargaInput = document.getElementById('Harga');
    
            function formatRibuan(angka) {
                return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
    
            hargaInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, ''); // hanya angka
                e.target.value = formatRibuan(value);
            });
    
            document.querySelector('form').addEventListener('submit', function () {
                hargaInput.value = hargaInput.value.replace(/\./g, ''); // hilangkan titik sebelum submit
            });
        });
    </script>    
@endsection
