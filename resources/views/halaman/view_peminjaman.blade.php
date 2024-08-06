@extends('layouts.index')
@section('title', 'Peminjaman')

@section('isihalaman')
<div class="mt-4 mx-10">
    <h3 class="text-center">Daftar Peminjaman Perpustakaan SMK Negeri 9</h3>

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

    
    <!-- Button Tambah Peminjaman -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahpeminjaman">Tambah Peminjaman</button>
    <!-- Table of borrowings -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td align="center">No</td>
                <td align="center">Judul Buku</td>
                <td align="center">Nama Siswa</td>
                <td align="center">Tanggal Pinjam</td>
                <td align="center">Tenggat Kembali</td>
                <td align="center">Tanggal Kembali</td>
                <td align="center">Denda</td>
                <td align="center">Status</td>
                <td align="center">Aksi</td>
            </tr>
        </thead>

        <tbody>
            @foreach ($peminjaman as $index => $pmj)
            <tr>
                <td align="center" scope="row">{{ $index + $peminjaman->firstItem() }}</td>
                <td>{{ $pmj->buku->judul }}</td>
                <td>{{ $pmj->siswa->nama }}</td>
                <td>{{ $pmj->tanggal_pinjam }}</td>
                <td>{{ $pmj->tenggat_kembali }}</td>
                <td>{{ $pmj->tanggal_kembali ? : '-' }}</td>
                <td>{{ $pmj->denda ? 'Rp ' . number_format($pmj->denda, 0, ',', '.') : '-' }}</td>
                <td align="center">
                    {{ $pmj->status ? 'belum dikembalikan' : 'sudah dikembalikan' }}
                </td>
                <td align="center">
                <div class="action-cell action-cell.threebuttons">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalPeminjamanEdit{{ $pmj->id_pinjam }}">Edit</button>

                    <!-- Modal Edit Peminjaman -->
                    <div class="modal fade" id="modalPeminjamanEdit{{ $pmj->id_pinjam }}" tabindex="-1" role="dialog" aria-labelledby="editPeminjaman" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPeminjaman">Form Edit Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('peminjaman.edit', $pmj->id_pinjam) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row mt-3">
                                            <label for="tanggal_pinjam" class="col-sm-4 col-form-label">Tanggal Pinjam</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ $pmj->tanggal_pinjam }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <label for="tenggat_kembali" class="col-sm-4 col-form-label">Tenggat Kembali</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="tenggat_kembali" name="tenggat_kembali" value="{{ $pmj->tenggat_kembali }}">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <div class="col-sm-12 text-end">
                                                <button type="button" name="tutup" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    |
                    <!-- Button Kembalikan Buku -->
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalKembalikan{{ $pmj->id_pinjam }}">Kembalikan</button>

                    <!-- Modal Kembalikan Buku -->
<div class="modal fade" id="modalKembalikan{{ $pmj->id_pinjam }}" tabindex="-1" role="dialog" aria-labelledby="kembalikanPeminjaman" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kembalikanPeminjaman">Form Pengembalian Peminjaman Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('peminjaman.kembalikan', $pmj->id_pinjam) }}" method="POST">
                    @csrf
                    <div class="form-group row mt-3">
                        <label for="nama" class="col-sm-4 col-form-label">Nama Siswa Peminjam</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $pmj->siswa->nama }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="judul" class="col-sm-4 col-form-label">Buku yang Dipinjam</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ $pmj->buku->judul }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="tenggat_kembali" class="col-sm-4 col-form-label">Tenggat Kembali</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="tenggat_kembali" name="tenggat_kembali" value="{{ $pmj->tenggat_kembali }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="tanggal_kembali" class="col-sm-4 col-form-label">Tanggal Kembali</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-sm-12 text-end">
                            <button type="button" name="tutup" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Kembalikan?</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                    |
                    <!-- Button Hapus Peminjaman -->
                    <a href="{{ route('peminjaman.hapus', $pmj->id_pinjam) }}" onclick="return confirm('Yakin mau hapus peminjaman ini?')">
                        <button class="btn btn-danger">Hapus</button>
                    </a>
                </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div>
        Halaman : {{ $peminjaman->currentPage() }} <br />
        Jumlah Peminjaman : {{ $peminjaman->total() }} <br />
        Data Per Halaman : {{ $peminjaman->perPage() }}

        {{ $peminjaman->links() }}
    </div>

    <!-- Modal Tambah Peminjaman -->
    <div class="modal fade" id="tambahpeminjaman" tabindex="-1" role="dialog" aria-labelledby="TambahPeminjaman" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TambahPeminjaman">Form Input Tambah Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('peminjaman.tambah') }}" method="post">
                        @csrf
                        <div class="form-group row mt-3">
                            <label for="id_swa" class="col-sm-4 col-form-label">Nama Siswa</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="id_swa" name="id_swa">
                                    @foreach ($siswa as $sw)
                                        <option value="{{ $sw->id_swa }}">{{ $sw->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="id_bku" class="col-sm-4 col-form-label">Judul Buku</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="id_bku" name="id_bku">
                                    @foreach ($buku as $bk)
                                        @if ($bk->status)  <!-- Hanya buku yang tersedia -->
                                            <option value="{{ $bk->id_bku }}">{{ $bk->judul }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="tanggal_pinjam" class="col-sm-4 col-form-label">Tanggal Pinjam</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="tenggat_kembali" class="col-sm-4 col-form-label">Tenggat Kembali</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="tenggat_kembali" name="tenggat_kembali">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-sm-12 text-end">
                                <button type="button" name="tutup" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
