@extends('layout.template')
@section('content')
<div class="container">
    <div class="container form-container mt-3">
        <div class="card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Tambah Produk</h2>
                <button type="button" class="btn btn-success btn-sm" id="add-row">+ Tambah Baris</button>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('stock_ins.store') }}" method="POST" id="stockForm">
                    @csrf
                    <div id="product-rows">
                        <div class="product-row row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Produk</label>
                                <select name="ProdukId[]" class="form-control" required>
                                    <option value="" selected disabled>Pilih Produk</option>
                                    @foreach ($produks as $produk)
                                        <option value="{{ $produk->ProdukId }}">{{ $produk->NamaProduk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Supplier</label>
                                <select name="SupplierId[]" class="form-control" required>
                                    <option value="" selected disabled>Pilih Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->SupplierId }}">{{ $supplier->Nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="Jumlah[]" class="form-control" placeholder="Jumlah" required>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-row">✕</button>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label class="form-label">Harga</label>
                                <input type="text" name="Harga[]" class="form-control harga-input" placeholder="Harga" required>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="Tgl[]" class="form-control" required>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label class="form-label">Kadaluarsa</label>
                                <input type="date" name="Kadaluarsa[]" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-maroon me-2">Simpan</button>
                        <a href="{{ route('stock_ins.index') }}" class="btn btn-outline-secondary">Keluar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hargaFormatter = (input) => {
            input.addEventListener('input', function () {
                let value = this.value.replace(/[^0-9]/g, '');
                this.value = new Intl.NumberFormat('id-ID').format(value);
            });
        };

        const addHargaFormatters = () => {
            document.querySelectorAll('.harga-input').forEach(hargaFormatter);
        };

        addHargaFormatters();

        document.getElementById('add-row').addEventListener('click', function () {
            const firstRow = document.querySelector('.product-row');
            const newRow = firstRow.cloneNode(true);

            // Bersihkan input
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            document.getElementById('product-rows').appendChild(newRow);
            addHargaFormatters();
        });

        document.getElementById('product-rows').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                const allRows = document.querySelectorAll('.product-row');
                if (allRows.length > 1) {
                    e.target.closest('.product-row').remove();
                }
            }
        });

        document.getElementById('stockForm').addEventListener('submit', function () {
            document.querySelectorAll('.harga-input').forEach(input => {
                input.value = input.value.replace(/\./g, '');
            });
        });
    });
</script>
@endsection