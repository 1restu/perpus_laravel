<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanModel;
use App\Models\SiswaModel;
use App\Models\BukuModel;
use App\Models\HistoryModel;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Method untuk menampilkan data peminjaman
    public function peminjamanTampil()
    {
        $dataPeminjaman = PeminjamanModel::orderby('id_pinjam', 'ASC')->paginate(6);
        $siswa = SiswaModel::all(); // Ambil semua data siswa
        $buku = BukuModel::where('status', true)->get(); // Ambil buku yang tersedia

        return view('halaman/view_peminjaman', ['peminjaman' => $dataPeminjaman, 'siswa' => $siswa, 'buku' => $buku]);
    }

    // Method tambah peminjaman
    public function peminjamanTambah(Request $request)
{
    $request->validate([
        'id_swa' => 'required|exists:siswa,id_swa',
        'id_bku' => 'required|exists:buku,id_bku',
        'tanggal_pinjam' => 'required|date',
        'tenggat_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
    ], [
        'id_swa.required' => 'Siswa wajib dipilih.',
        'id_bku.required' => 'Buku wajib dipilih.',
        'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
        'tenggat_kembali.required' => 'Tenggat kembali wajib diisi.',
        'tenggat_kembali.after_or_equal' => 'Tenggat kembali tidak boleh sebelum tanggal pinjam.',
    ]);

    // Cek apakah buku tersedia
    $buku = BukuModel::find($request->id_bku);
    if (!$buku || $buku->status == false) {
        return redirect('/peminjaman')->with('error', 'Buku tidak tersedia.');
    }

    try {
        PeminjamanModel::create([
            'id_swa' => $request->id_swa,
            'id_bku' => $request->id_bku,
            'tanggal_pinjam' => Carbon::parse($request->tanggal_pinjam), // Pastikan ini adalah Carbon instance
            'tenggat_kembali' => Carbon::parse($request->tenggat_kembali), // Pastikan ini adalah Carbon instance
            'status' => true,
            'denda' => 0, // Tambahkan nilai default untuk denda
        ]);

        // Update status buku
        $buku->update(['status' => false]);

        return redirect('/peminjaman')->with('success', 'Data peminjaman baru berhasil ditambahkan.');
    } catch (\Exception $e) {
        // Log the exception message
        \Log::error('Error adding new peminjaman: ' . $e->getMessage());
        return redirect('/peminjaman')->with('error', 'Data peminjaman baru gagal ditambahkan.');
    }
}



    // Method hapus peminjaman
    public function peminjamanHapus($id_pinjam)
{
    $peminjaman = PeminjamanModel::find($id_pinjam);

    if (!$peminjaman) {
        return redirect('/peminjaman')->with('error', 'Data peminjaman tidak ditemukan.');
    }

    try {
        // Ambil nama siswa dan judul buku
        $siswa = SiswaModel::find($peminjaman->id_swa);
        $buku = BukuModel::find($peminjaman->id_bku);

        if ($siswa && $buku) {
            // Buat entri di tabel history jika peminjaman sudah dikembalikan
            if ($peminjaman->status == false) {
                HistoryModel::create([
                    'id_swa' => $peminjaman->id_swa,
                    'nama_swa' => $siswa->nama, // Pastikan nama siswa tersedia di SiswaModel
                    'id_bku' => $peminjaman->id_bku,
                    'judul' => $buku->judul, // Pastikan judul buku tersedia di BukuModel
                    'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                    'tenggat_kembali' => $peminjaman->tenggat_kembali,
                    'tanggal_kembali' => $peminjaman->tanggal_kembali,
                    'denda' => $peminjaman->denda,
                ]);
            }

            // Kembalikan status buku menjadi tersedia jika peminjaman belum dikembalikan
            if ($peminjaman->status == true) {
                $buku->update(['status' => true]);
            }

            $peminjaman->delete();

            return redirect('/peminjaman')->with('success', 'Data peminjaman berhasil dihapus dan di pindah di history.');
        } else {
            return redirect('/peminjaman')->with('error', 'Data siswa atau buku tidak ditemukan.');
        }
    } catch (\Exception $e) {
        return redirect('/peminjaman')->with('error', 'Data peminjaman gagal dihapus.');
    }
}


    // Method untuk mengembalikan buku
    public function peminjamankembalikan(Request $request, $id_pinjam)
    {
        $peminjaman = PeminjamanModel::find($id_pinjam);
    
        if (!$peminjaman) {
            return redirect('/peminjaman')->with('error', 'Data peminjaman tidak ditemukan.');
        }
    
        if ($peminjaman->status == false) {
            return redirect('/peminjaman')->with('error', 'Buku sudah dikembalikan.');
        }
    
        $tanggal_kembali = Carbon::parse($request->input('tanggal_kembali'));
    
        // Validasi agar tanggal_kembali tidak sebelum tenggat_kembali
        if ($tanggal_kembali->lt($peminjaman->tenggat_kembali)) {
            return redirect('/peminjaman')->with('error', 'Tanggal pengembalian tidak boleh sebelum tenggat kembali.');
        }
    
        $denda = 0;
    
        // Hitung denda jika pengembalian lewat tenggat waktu
        if ($tanggal_kembali->gt($peminjaman->tenggat_kembali)) {
            $denda = $tanggal_kembali->diffInDays($peminjaman->tenggat_kembali) * 500; // 500 adalah besaran denda per hari
        }
    
        try {
            // Update status peminjaman
            $peminjaman->update([
                'tanggal_kembali' => $tanggal_kembali,
                'denda' => $denda,
                'status' => false,
            ]);
    
            // Update status buku menjadi tersedia
            $buku = BukuModel::find($peminjaman->id_bku);
            if ($buku) {
                $buku->update(['status' => true]);
            }
    
            return redirect('/peminjaman')->with('success', 'Buku berhasil dikembalikan.');
        } catch (\Exception $e) {
            \Log::error('Error returning book: ' . $e->getMessage());
            return redirect('/peminjaman')->with('error', 'Buku gagal dikembalikan.');
        }
    }    

    // Method untuk mengedit peminjaman
    public function peminjamanedit(Request $request, $id_pinjam)
    {
        $peminjaman = PeminjamanModel::find($id_pinjam);

        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tenggat_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ], [
            'tanggal_pinjam.required' => 'Tanggal Pinjam wajib diisi',
            'tanggal_kembali.required' => 'Tanggal pinjam wajib diisi.',
            'tenggat_kembali.after_or_equal' => 'Tenggat kembali tidak boleh sebelum tanggal pinjam.',
        ]);

        $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
        $peminjaman->tenggat_kembali = $request->tenggat_kembali;
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil diperbarui.');
    }
}
