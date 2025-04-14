@extends('layout.template')
@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Kategori</h1>

    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pencarian dan Tambah Kategori -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <input type="text" class="form-control w-50" id="search-input" placeholder="Cari kategori...">
        <a href="{{ route('kategoris.create') }}" class="btn btn-primary">Tambah Kategori</a>
    </div>

    <div class="table-responsive">
        <div class="table-container mt-3">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="kategori-table-body">
                    @foreach ($kategoris->sortByDesc('KategoriId') as $kategori)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kategori->Nama }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('kategoris.edit', $kategori->KategoriId) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kategoris.destroy', $kategori->KategoriId) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>     
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

    // Filter pencarian kategori
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#kategori-table-body tr');

        tableRows.forEach(row => {
            const nameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            if (nameCell.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<style>
    /* Styling tabel */
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
