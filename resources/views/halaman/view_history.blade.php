@extends ('layouts.index')
@section ('title', 'History')

@section ('isihalaman')
<div class="mt-4 mx-10">
<h3 class="text-center">History Peminjaman Perpustakaan Malang</h3>

<!-- Alert messages -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th align="center">No</th>
                <th align="center">Nama siswa</th>
                <th align="center">Judul buku</th>
                <th align="center">Tanggal pinjam</th>
                <th align="center">Tenggat kembali</th>
                <th align="center">Tanggal kembali</th>
                <th align="center">Denda</th>
                <th align="center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($history as $index => $hs)
            <tr>
                <td align="center" scope="row">{{ $index + $history->firstItem() }}</td>
                <td>{{ $hs->nama_swa }}</td>
                <td>{{ $hs->judul }}</td>
                <td>{{ $hs->tanggal_pinjam }}</td>
                <td>{{ $hs->tenggat_kembali }}</td>
                <td>{{ $hs->tanggal_kembali }}</td>
                <td>{{ $hs->denda }}</td>
                <td align="center">
                    <a href="{{ route('history.hapus', $hs->id_history) }}" onclick="return confirm('Yakin mau hapus data history ini?')">
                        <button class="btn btn-danger">Delete</button>
                    </a>                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div>
        Halaman : {{ $history->currentPage() }} <br />
        Jumlah data history : {{ $history->total() }} <br />
        Data Per Halaman : {{ $history->perPage() }}

        {{ $history->links() }}
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let alertElement = document.querySelector('.alert');
            if (alertElement) {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
                setTimeout(() => alertElement.remove(), 600); // Remove after fade out
            }
        }, 5000); // Alert will disappear after 5 seconds
    });
</script>
@endsection
