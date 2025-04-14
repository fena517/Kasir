@extends('layout.template')
@section('content')
<div class="container">
    <div class="container form-container mt-3"> <!-- Reduced margin-top here -->
        <div class="card">
            <div class="card-header py-3">
                <h2 class="mb-0">Tambah Unit</h2>
            </div>
            <div class="card-body p-4">
            <form action="{{ route('units.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="Nama" class="form-label">Nama</label>
                            <input type="text" name="Nama" id="Nama" class="form-control" placeholder="Masukkan Kategori" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-maroon me-2">Simpan</button>
                        <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">Keluar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection