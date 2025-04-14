@extends('layout.template')
@section('content')
<div class="container">
    <h1>Daftar Pelanggan</h1>
    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Form Pencarian -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div class="d-flex">
            <input type="text" class="form-control" id="search-input" placeholder="Cari pelanggan..." />
        </div>
        @if(Auth::check() && Auth::user()->role == 'admin') 
        <a href="{{ route('pelanggans.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
        @endif
    </div>
    
    <div class="table-responsive">
        <div class="table-container mt-3">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Nomor Telepon</th>
                        @if(Auth::check() && Auth::user()->role == 'admin')
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="pelanggan-table-body">
                    @foreach ($pelanggans->sortByDesc('PelangganId') as $pelanggan)
                        <tr>
                            <td>{{ ($pelanggans->currentPage() - 1) * $pelanggans->perPage() + $loop->iteration }}</td>
                            <td>{{ $pelanggan->NamaPelanggan }}</td>
                            <td>{{ $pelanggan->Alamat }}</td>
                            <td>{{ $pelanggan->NomorTelepon }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    @if(Auth::check() && Auth::user()->role == 'admin')
                                    <a href="{{ route('pelanggans.edit', $pelanggan->PelangganId) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pelanggans.destroy', $pelanggan->PelangganId) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $pelanggans->links() }}
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

    // Script to filter customers based on search input
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#pelanggan-table-body tr');

        tableRows.forEach(row => {
            const nameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const addressCell = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const phoneCell = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            if (nameCell.includes(searchQuery) || addressCell.includes(searchQuery) || phoneCell.includes(searchQuery)) {
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
    .pagination {
        margin-top: 20px;
        justify-content: center;
    }
</style>
@endsection
