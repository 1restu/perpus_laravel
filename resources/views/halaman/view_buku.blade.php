@extends ('layouts.index')
@section ('title', 'Buku')

@section ('isihalaman')
<div class="mt-4 mx-10">
<h3 class="text-center">Daftar Buku Perpustakaan SMK Negeri 9</h3>

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

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahbuku">Tambah data buku</button>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td align="center">No</td>
                <td align="center">Judul Buku</td>
                <td align="center">Penulis</td>
                <td align="center">Tanggal Terbit</td>
                <td align="center">Penerbit</td>
                <td align="center">Status</td>
                <td align="center">Aksi</td>
            </tr>
        </thead>

        <tbody>
            @foreach ($buku as $index => $bk)
            <tr>
                <td align="center" scope="row">{{ $index + $buku->firstItem() }}</td>
                <td>{{ $bk->judul }}</td>
                <td>{{ $bk->penulis }}</td>
                <td>{{ $bk->tahun_terbit }}</td>
                <td>{{ $bk->penerbit }}</td>
                <td align="center">
                    {{ $bk->status ? 'Tersedia' : 'Dipinjam' }}
                </td>
                <td align="center">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalBukuEdit{{ $bk->id_bku }}">Edit</button>

                    <!-- Modal Edit Buku -->
    <div class="modal fade" id="modalBukuEdit{{ $bk->id_bku }}" tabindex="-1" role="dialog" aria-labelledby="editbuku" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editbuku">Form Input Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="formbukuedit" id="formbukuedit" action="{{ route('buku.edit', $bk->id_bku) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row mt-3">
                            <label for="id_bku" class="col-sm-4 col-form-label">Judul Buku</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ $bk->judul }}">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="penulis" class="col-sm-4 col-form-label">Penulis</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="penulis" name="penulis" value="{{ $bk->penulis }}">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="tahun_terbit" class="col-sm-4 col-form-label">Tahun Terbit</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ $bk->tahun_terbit }}">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="penerbit" class="col-sm-4 col-form-label">Penerbit</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ $bk->penerbit }}">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12 text-end">
                                <button type="button" name="tutup" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                    |
                    <a href="{{ route('buku.hapus', $bk->id_bku) }}" onclick="return confirm('Yakin mau hapus buku ini?')">
                        <button class="btn btn-danger">Delete</button>
                    </a>                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div>
        Halaman : {{ $buku->currentPage() }} <br />
        Jumlah Buku : {{ $buku->total() }} <br />
        Data Per Halaman : {{ $buku->perPage() }}

        {{ $buku->links() }}
    </div>


    <!-- Modal Tambah Buku -->
    <div class="modal fade" id="tambahbuku" tabindex="-1" role="dialog" aria-labelledby="TambahBuku" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TambahBuku">Form Input Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="formtambahbuku" id="formtambahbuku" action="/buku/tambah" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mt-3">
                            <label for="judul" class="col-sm-4 col-form-label">Judul Buku</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="judul" name="judul">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="penulis" class="col-sm-4 col-form-label">Penulis</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="penulis" name="penulis">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="tahun_terbit" class="col-sm-4 col-form-label">Tahun Terbit</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="penerbit" class="col-sm-4 col-form-label">Penerbit</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="penerbit" name="penerbit">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12 text-end">
                                <button type="button" name="tutup" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Tambah Buku -->
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
        }, 5000); // Alert will disappear after 3 seconds
    });
</script>
@endsection
