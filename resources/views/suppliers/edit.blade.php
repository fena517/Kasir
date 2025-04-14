@extends('layout.template')

@section('content')
<div class="container">
    <div class="container form-container mt-3">
        <div class="card">
            <div class="card-header py-3">
                <h2 class="mb-0">Edit Supplier</h2>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('suppliers.update', $supplier->SupplierId) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="Nama" class="form-label">Nama</label>
                            <input type="text" name="Nama" id="Nama" class="form-control" value="{{ $supplier->Nama }}" placeholder="Masukkan nama supplier" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="Alamat" class="form-label">Alamat</label>
                            <input type="text" name="Alamat" id="Alamat" class="form-control" value="{{ $supplier->Alamat }}" placeholder="Alamat supplier" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Kontak" class="form-label">Kontak</label>
                            <input type="text" name="Kontak" id="Kontak" class="form-control" value="{{ $supplier->Kontak }}" placeholder="Kontak supplier" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-maroon me-2">Update</button>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Keluar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
