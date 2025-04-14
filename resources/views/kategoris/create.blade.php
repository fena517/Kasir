@extends('layout.template')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-10">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white text-center py-4 border-bottom">
                    <h4 class="fw-bold text-dark mb-1">Tambah Kategori</h4>
                    <p class="text-muted small">Silakan isi nama kategori dengan benar</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('kategoris.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="Nama" class="form-label fw-semibold text-dark">Nama Kategori</label>
                            <input type="text" name="Nama" id="Nama" class="form-control rounded-3 py-2 px-3 border border-2 border-primary" placeholder="Masukkan nama kategori" required>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('kategoris.index') }}" class="btn btn-outline-secondary rounded-3 px-4 py-2">Batal</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4 py-2">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-3 small">Pastikan kategori sudah benar sebelum disimpan.</p>
        </div>
    </div>
</div>
@endsection
