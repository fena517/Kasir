@extends('layout.template')

@section('content')
<div class="container">
    <h2 class="mb-4">Buat Penjualan Baru</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('penjualans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="TanggalPenjualan" class="form-label">Tanggal Penjualan</label>
            <input type="date" class="form-control" name="TanggalPenjualan" value="{{ old('TanggalPenjualan', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="PelangganId" class="form-label">Pilih Pelanggan</label>
            <select class="form-control" name="PelangganId">
            <option value="">-- Pilih Pelanggan --</option>
            @foreach($pelanggans as $pelanggan)
                <option value="{{ $pelanggan->PelangganId }}" {{ old('PelangganId') == $pelanggan->PelangganId ? 'selected' : '' }}>
                    {{ $pelanggan->NamaPelanggan }}
                </option>
            @endforeach
            </select>
        </div>

        <hr>
        <h4>Tambah Produk</h4>
        <div id="produk-container">
            <div class="produk-row d-flex gap-2 mb-2">
                <select class="form-control produk-select" name="ProdukId[]" onchange="updateHarga(this)" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->ProdukId }}" data-harga="{{ $produk->Harga }}">
                            {{ $produk->NamaProduk }} 
                        </option>
                    @endforeach
                </select>
                <input type="number" class="form-control jumlah-input" name="JumlahProduk[]" min="1" value="1" onchange="updateSubtotal(this)" required>
                <input type="text" class="form-control harga-input" readonly placeholder="Harga">
                <input type="text" class="form-control subtotal-input" readonly placeholder="Subtotal">
                <button type="button" class="btn btn-danger" onclick="removeProduk(this)">X</button>
            </div>
        </div>
        <button type="button" class="btn btn-success mb-3" onclick="addProduk()">Tambah Produk</button>

        <div class="mb-3">
            <label for="TotalHarga" class="form-label">Total Harga</label>
            <input type="text" class="form-control" name="TotalHarga" id="TotalHarga" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penjualans.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    function updateHarga(select) {
        let harga = select.options[select.selectedIndex].getAttribute('data-harga');
        let row = select.closest('.produk-row');
        row.querySelector('.harga-input').value = harga;
        updateSubtotal(row.querySelector('.jumlah-input'));
    }

    function updateSubtotal(input) {
        let row = input.closest('.produk-row');
        let harga = row.querySelector('.harga-input').value;
        let jumlah = input.value;
        let subtotal = harga * jumlah;
        row.querySelector('.subtotal-input').value = subtotal;

        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal-input').forEach(el => {
            total += parseFloat(el.value) || 0;
        });
        document.getElementById('TotalHarga').value = total;
    }

    function addProduk() {
        let container = document.getElementById('produk-container');
        let newRow = document.querySelector('.produk-row').cloneNode(true);

        newRow.querySelector('.produk-select').value = "";
        newRow.querySelector('.jumlah-input').value = 1;
        newRow.querySelector('.harga-input').value = "";
        newRow.querySelector('.subtotal-input').value = "";
        container.appendChild(newRow);
    }

    function removeProduk(button) {
        if (document.querySelectorAll('.produk-row').length > 1) {
            button.closest('.produk-row').remove();
            updateTotal();
        }
    }
</script>
@endsection
