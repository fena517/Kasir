@extends('layout.template')
@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Produk</h1>

    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pencarian dan Tambah Produk -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <input type="text" class="form-control w-50" id="search-input" placeholder="Cari produk...">
        @if(Auth::check() && Auth::user()->role == 'admin')
        <a href="{{ route('produks.create') }}" class="btn btn-primary">Tambah Produk</a>
        @endif
    </div>

    <div class="table-responsive">
        <div class="table-container mt-3">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kadaluarsa</th>
                        @if(Auth::check() && Auth::user()->role == 'admin')
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="produk-table-body">
                    @foreach ($produks->sortByDesc('ProdukId') as $produk)
                        <tr>
                            <td>{{ ($produks->currentPage() - 1) * $produks->perPage() + $loop->iteration }}</td>
                            <td>
                                @if($produk->GambarProduk)
                                    <img src="{{ asset($produk->GambarProduk) }}" alt="Gambar Produk" width="60" height="60">
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>{{ $produk->NamaProduk }}</td>
                            <td>Rp {{ number_format((int) $produk->Harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>
                            @if ($produk->stockIns->isNotEmpty())
                                {{ \Carbon\Carbon::parse($produk->stockIns->last()->Kadaluarsa)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                            </td>
                            <td>  
                                @if(Auth::check() && Auth::user()->role == 'admin')  
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('produks.show', $produk->ProdukId) }}" class="btn btn-info btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('produks.edit', $produk->ProdukId) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('produks.destroy', $produk->ProdukId) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="d-inline">
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
            {{ $produks->links() }}
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
        const tableRows = document.querySelectorAll('#produk-table-body tr');

        tableRows.forEach(row => {
            const nameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const priceCell = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const stockCell = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            if (nameCell.includes(searchQuery) || priceCell.includes(searchQuery) || stockCell.includes(searchQuery)) {
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
    img {
        object-fit: cover;
        border-radius: 5px;
    }
</style>
@endsection