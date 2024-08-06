@extends ('layouts.index')
@section ('title', 'Siswa')

@section ('isihalaman')
<div class="mt-4 mx-10">
<h3 class="text-center">Daftar Siswa Perpustakaan SMK Negeri 9</h3>

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

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahsiswa">Tambah data siswa</button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td align="center">No</td>
                <td align="center">Nama siswa</td>
                <td align="center">Kelas</td>
                <td align="center">No telepon</td>
                <td align="center">Alamat</td>
                <td align="center">Aksi</td>
            </tr>
        </thead>

        <tbody>
            @foreach ($siswa as $index => $sw)
            <tr>
                <td align="center" scope="row">{{ $index + $siswa->firstItem() }}</td>
                <td>{{ $sw->nama }}</td>
                <td>{{ $sw->kelas }}</td>
                <td>{{ $sw->no_tlp }}</td>
                <td>{{ $sw->alamat }}</td>
                <td align="center">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalSiswaEdit{{ $sw->id_swa }}">Edit</button>

                    <!-- Modal Edit Buku -->
    <div class="modal fade" id="modalSiswaEdit{{ $sw->id_swa }}" tabindex="-1" role="dialog" aria-labelledby="editsiswa" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editsiswa">Form Input Edit Data siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="formsiswaedit" id="formsiswaedit" action="{{ route('siswa.edit', $sw->id_swa) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row mt-3">
                            <label for="id_swa" class="col-sm-4 col-form-label">Nama siswa</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ $sw->nama }}">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="kelas" class="col-sm-4 col-form-label">Kelas</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $sw->kelas }}">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="no_tlp" class="col-sm-4 col-form-label">No Telepon</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="no_tlp" name="no_tlp" value="{{ $sw->no_tlp }}">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="alamat" class="col-sm-4 col-form-label">alamat</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $sw->alamat }}">
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
                    <a href="{{ route('siswa.hapus', $sw->id_swa) }}" onclick="return confirm('Yakin mau hapus data siswa ini?')">
                        <button class="btn btn-danger">Delete</button>
                    </a>                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div>
        Halaman : {{ $siswa->currentPage() }} <br />
        Jumlah Siswa : {{ $siswa->total() }} <br />
        Data Per Halaman : {{ $siswa->perPage() }}

        {{ $siswa->links() }}
    </div>


    <!-- Modal Tambah Buku -->
    <div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="TambahSiswa" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TambahSiswa">Form Input Tambah Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="formtambahsiswa" id="formtambahsiswa" action="/siswa/tambah" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mt-3">
                            <label for="nama" class="col-sm-4 col-form-label">Nama siswa</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="kelas" class="col-sm-4 col-form-label">Kelas</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="kelas" name="kelas">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="no_tlp" class="col-sm-4 col-form-label">No telepon</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="no_tlp" name="no_tlp">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="alamat" class="col-sm-4 col-form-label">alamat</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="alamat" name="alamat">
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
