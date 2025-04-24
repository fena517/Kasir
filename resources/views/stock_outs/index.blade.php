@extends('layout.template')
@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Stok Keluar</h1>

    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pencarian dan Tambah Stok Keluar -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <input type="text" class="form-control w-50" id="search-input" placeholder="Cari produk...">
        <a href="{{ route('stock_outs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah </a>
    </div>

    <div class="table-responsive">
        <div class="table-container mt-3">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                    </tr>
                </thead>
                <tbody id="stock-table-body">
                    @foreach ($stock_outs->sortByDesc('KeluarId') as $stock_out)
                        <tr>
                            <td>{{ ($stock_outs->currentPage() - 1) * $stock_outs->perPage() + $loop->iteration }}</td>
                            <td>{{ $stock_out->produk->NamaProduk }}</td>
                            <td>{{ $stock_out->Jumlah }}</td>
                            <td>{{ \Carbon\Carbon::parse($stock_out->Tgl)->format('d/m/Y') }}</td>
                            <td>{{ $stock_out->Alasan }}</td>
                            <td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $stock_outs->links() }}
        </div>
    </div>
</div>

<script>
    // Hilangkan flash message setelah 5 detik
    setTimeout(function() {
        var message = document.getElementById('flash-message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000);

    // Filter pencarian produk
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#stock-table-body tr');

        tableRows.forEach(row => {
            const productCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const reasonCell = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

            if (productCell.includes(searchQuery) || reasonCell.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    
    th, td {
        padding: 12px 15px;
        text-align: center; /* Sama dengan tampilan unit */
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
