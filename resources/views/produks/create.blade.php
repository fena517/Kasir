@extends('layout.template')

@section('content')
<div class="container form-container mt-3">
    <div class="card">
        <div class="card-header py-3">
            <h2 class="mb-0">Tambah Produk</h2>
        </div>
        <div class="card-body p-4">

            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('produks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <label for="KodeProduk" class="form-label">Kode Produk</label>
                        <input type="text" name="KodeProduk" id="KodeProduk" class="form-control"
                               value="{{ old('KodeProduk') }}" placeholder="Masukkan kode produk" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <label for="NamaProduk" class="form-label">Nama Produk</label>
                        <input type="text" name="NamaProduk" id="NamaProduk" class="form-control"
                               value="{{ old('NamaProduk') }}" placeholder="Masukkan nama produk" required>
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
                        <input type="text" name="Harga" id="Harga" class="form-control"
                               value="{{ old('Harga') }}" placeholder="Masukkan harga" required>
                    </div>
                    <div class="col-md-6">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control"
                               value="{{ old('stok') }}" placeholder="Masukkan stok" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="GambarProduk" class="form-label">Gambar Produk</label>
                        <input type="file" name="GambarProduk" id="GambarProduk" class="form-control">
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

{{-- Format angka harga --}}
<script>
    const hargaInput = document.getElementById('Harga');

    hargaInput.addEventListener('input', function (e) {
        let value = e.target.value;
        value = value.replace(/[^0-9]/g, '');
        value = new Intl.NumberFormat('id-ID').format(value);
        e.target.value = value;
    });

    document.querySelector('form').addEventListener('submit', function () {
        let hargaInput = document.getElementById('Harga');
        hargaInput.value = hargaInput.value.replace(/\./g, '');
    });
</script>
@endsection