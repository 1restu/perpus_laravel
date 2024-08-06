<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BukuModel;
use App\Models\PeminjamanModel;

class BukuController extends Controller
{
    // Method untuk menampilkan data buku
    public function bukutampil()
    {
        $databuku = BukuModel::orderby('id_bku', 'ASC')->paginate(6);
        return view('halaman/view_buku', ['buku' => $databuku]);
    }

    // Method tambah buku
    public function bukutambah(Request $request)
{
    $request->validate([
        'judul' => 'required|unique:buku',
        'penulis' => 'required|string',
        'tahun_terbit' => 'required|numeric',
        'penerbit' => 'required|string'
    ], [
        'judul.required' => 'Judul buku wajib diisi.',
        'judul.unique' => 'Judul telah digunakan oleh buku lain, silakan gunakan judul yang berbeda.',
        'penulis.required' => 'Penulis buku wajib diisi.',
        'penulis.string' => 'Nama penulis tidak boleh berupa angka.',
        'tahun_terbit.required' => 'Tahun terbit buku wajib diisi.',
        'tahun_terbit.numeric' => 'Tahun terbit harus berupa angka.',
        'penerbit.required' => 'Penerbit buku wajib diisi.',
        'penerbit.string' => 'Nama penerbit tidak boleh berupa angka.',
    ]);

    try {
        BukuModel::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
            'penerbit' => $request->penerbit,
            'status' => true, // Default status to true (tersedia)
        ]);

        return redirect('/buku')->with('success', 'Buku baru berhasil ditambahkan.');
    } catch (\Exception $e) {
        return redirect('/buku')->with('error', 'Buku baru gagal ditambahkan.');
    }
}

public function bukuHapus($id_bku)
{
    $buku = BukuModel::find($id_bku);

    if (!$buku) {
        return redirect('/buku')->with('error', 'Buku tidak ditemukan.');
    }

    // Cek apakah buku terkait dengan peminjaman yang masih ada
    $peminjamanTerkait = PeminjamanModel::where('id_bku', $id_bku)->exists();

    if ($peminjamanTerkait) {
        return redirect('/buku')->with('error', 'Buku tidak dapat dihapus karena masih terkait dengan peminjaman.');
    }

    try {
        $buku->delete();
        return redirect('/buku')->with('success', 'Buku berhasil dihapus.');
    } catch (\Exception $e) {
        \Log::error('Error deleting book: ' . $e->getMessage());
        return redirect('/buku')->with('error', 'Buku gagal dihapus.');
    }
}



public function bukuedit($id_bku, Request $request )
{
    $buku = BukuModel::where('id_bku', $id_bku)->first();

    if (!$buku) {
        return redirect('/buku')->with('error', 'Buku tidak ditemukan!');
    }

    $peminjamanTerkait = PeminjamanModel::where('id_bku', $id_bku)->exists();

    if ($peminjamanTerkait) {
        return redirect('/buku')->with('error', 'Buku tidak dapat diedit karena masih terkait dengan peminjaman.');
    }

    $request->validate([
        'judul' => [
            'required',
            Rule::unique('buku', 'judul')->ignore($buku)
        ],
        'penulis' => 'required|string',
        'tahun_terbit' => 'required|numeric',
        'penerbit' => 'required|string'
    ], [
        'judul.required' => 'Judul buku wajib diisi.',
        'judul.unique' => 'Judul telah digunakan oleh buku lain, silakan gunakan judul yang berbeda.',
        'penulis.required' => 'Penulis buku wajib diisi.',
        'penulis.string' => 'Nama penulis tidak boleh berupa angka.',
        'tahun_terbit.required' => 'Tahun terbit buku wajib diisi.',
        'tahun_terbit.numeric' => 'Tahun terbit harus berupa angka.',
        'penerbit.required' => 'Penerbit buku wajib diisi.',
        'penerbit.string' => 'Nama penerbit tidak boleh berupa angka.',
    ]);

    try {
        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
            'penerbit' => $request->penerbit,
        ]);

        return redirect('/buku')->with('success', 'Buku berhasil diedit.');
    } catch (\Exception $e) {
        return redirect('/buku')->with('error', 'Buku gagal diperbarui.');
    }
}
}

