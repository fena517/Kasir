@extends('layout.template')
@section('content')
<div class="container">
    <div class="container mt-4">
        <h1 class="mb-4">Daftar Penjualan</h1>
        
        @if(session('success'))
            <div id="flash-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Form Pencarian -->
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <input type="text" class="form-control" id="search-input" placeholder="Cari penjualan..." />
            </div>
            <a href="{{ route('penjualans.create') }}" class="btn btn-primary">Tambah Penjualan</a>
        </div>
        
        <div class="table-responsive">
            <div class="table-container mt-3">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal <br> Penjualan</th>
                            <th>Produk</th>
                            <th>Total Harga</th>
                            <th>Pelanggan</th>
                            @if(Auth::check() && Auth::user()->role == 'admin') 
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="penjualan-table-body">
                        @foreach ($penjualans as $penjualan)
                            <tr>
                                <td>{{ ($penjualans->currentPage() - 1) * $penjualans->perPage() + $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d/m/Y') }}</td>
                                <td>
                                    @foreach ($penjualan->details as $detail)
                                        {{ $detail->produk->NamaProduk ?? 'Produk Tidak Ditemukan' }}<br>
                                    @endforeach
                                </td>
                                <td>Rp. {{ number_format($penjualan->TotalHarga, 2, ',', '.') }}</td>
                                <td>{{ $penjualan->pelanggan->NamaPelanggan }}</td>
                                <td>
                                    @if(Auth::check() && Auth::user()->role == 'admin') 
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('penjualans.show', $penjualan->PenjualanId) }}" class="btn btn-warning btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($penjualan->pembayaran)
                                            <a href="{{ route('pembayarans.show', $penjualan->pembayaran->PembayaranId) }}" class="btn btn-success btn-sm" title="Struk">
                                                <i class="fas fa-receipt"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">Belum Dibayar</span>
                                        @endif
                                        <form action="{{ route('penjualans.destroy', $penjualan->PenjualanId) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>                                    
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $penjualans->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    // Script to hide flash message after 5 seconds
    setTimeout(function() {
        var message = document.getElementById('flash-message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000);

    // Script to filter sales based on search input
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#penjualan-table-body tr');

        tableRows.forEach(row => {
            const dateCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const totalPriceCell = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const customerCell = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            if (dateCell.includes(searchQuery) || totalPriceCell.includes(searchQuery) || customerCell.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<style>
    /* Styling table */
    table {
        border-collapse: collapse;
        width: 100%;
    }
      
    th, td {
        padding: 12px 15px;
        text-align: center; /* Rata tengah */
        vertical-align: middle;
    }

    th {
        background-color: #4e73df;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #e6e6e6;
    }

    .table-responsive {
        margin-top: 20px;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
    }

    .btn-warning {
        background-color: #f0ad4e;
        border-color: #f0ad4e;
    }

    .btn-warning:hover {
        background-color: #ec971f;
        border-color: #d58512;
    }

    .btn-danger {
        background-color: #d9534f;
        border-color: #d9534f;
    }

    .btn-danger:hover {
        background-color: #c9302c;
        border-color: #ac2925;
    }
</style>
@endsection
