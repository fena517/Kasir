@extends('layout.template')

@section('content')
<style>
    /* Background dan header */
.card-header {
    background-color: #6f42c1; /* Ungu gelap */
    color: rgb(0, 0, 0);
}

.card {
    border-radius: 8px;
    border: 2px solid #6f42c1; /* Ungu */
}

.btn-maroon {
    background-color: #d35400; /* Oranye kemerahan */
    color: white;
    border: none;
}

.btn-maroon:hover {
    background-color: #e67e22; /* Sedikit lebih terang saat hover */
}

.btn-outline-secondary {
    border-color: #2ecc71; /* Hijau */
    color: #2ecc71;
}

.btn-outline-secondary:hover {
    background-color: #2ecc71;
    color: white;
}

/* Table styling */
.table th {
    background-color: #6f42c1; /* Ungu gelap */
    color: white;
    font-weight: bold;
}

.table td {
    border: 2px solid #ddd; /* Garis border yang lebih jelas */
}

/* Input fields */
.form-control {
    border: 2px solid #6f42c1; /* Ungu */
}

.form-control:focus {
    border-color: #2ecc71; /* Hijau saat fokus */
    box-shadow: 0 0 5px rgba(46, 204, 113, 0.5);
}
</style>
<div class="container form-container mt-3">
    <div class="card">
        <div class="card-header py-3">
            <h2>Edit Pelanggan</h2>
        </div>
        <div class="card-body p-4">
            <!-- resources/views/pelanggans/edit.blade.php -->
            <form action="{{ route('pelanggans.update', $pelanggan->PelangganId) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="NamaPelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" name="NamaPelanggan" class="form-control" value="{{ $pelanggan->NamaPelanggan }}" required>
                </div>
                <div class="mb-3">
                    <label for="Alamat" class="form-label">Alamat</label>
                    <input type="text" name="Alamat" class="form-control" value="{{ $pelanggan->Alamat }}" required>
                </div>
                <div class="mb-3">
                    <label for="NomorTelepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="NomorTelepon" class="form-control" value="{{ $pelanggan->NomorTelepon }}" required>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-maroon me-2">Simpan</button>
                    <a href="{{ route('pelanggans.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
