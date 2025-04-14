@extends('layout.template')
@section('content')
<div class="container">
    <div class="container form-container mt-3"> <!-- Reduced margin-top here -->
        <div class="card">
            <div class="card-header py-3">
                <h2 class="mb-0">Tambah supplier</h2>
            </div>
            <div class="card-body p-4">
            <form action="{{ route('suppliers.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="Nama" class="form-label">Nama</label>
                            <input type="text" name="Nama" id="Nama" class="form-control" placeholder="Masukkan nama supplier" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <input type="text" name="Alamat" id="Alamat" class="form-control" placeholder="Alamat supplier" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Kontak" class="form-label">Kontak</label>
                            <input type="text" name="Kontak" id="Kontak" class="form-control" placeholder="Kontak supplier" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-maroon me-2">Simpan</button>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Keluar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection