<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaModel;
use App\Models\PeminjamanModel;

class SiswaController extends Controller
{
    // Method untuk menampilkan data siswa
    public function siswatampil()
    {
        $datasiswa = SiswaModel::orderby('id_swa', 'ASC')->paginate(6);
        return view('halaman/view_siswa', ['siswa' => $datasiswa]);
    }

    // Method tambah siswa
    public function siswatambah(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:siswa|regex:/[a-zA-Z]/',
            'kelas' => 'required|numeric',
            'no_tlp' => 'required|numeric',
            'alamat' => 'required|string|regex:/[a-zA-Z]/'
        ], [
            'nama.required' => 'Nama siswa wajib diisi.',
            'nama.unique' => 'Nama siswa sudah ada, silakan gunakan nama yang berbeda.',
            'nama.regex' => 'Nama siswa harus mengandung setidaknya satu huruf.',
            'kelas.required' => 'Kelas siswa wajib diisi.',
            'kelas.numeric' => 'Kelas siswa harus berupa angka.',
            'no_tlp.required' => 'Nomor telepon wajib diisi.',
            'no_tlp.numeric' => 'Nomor telepon harus berupa angka.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa string.',
            'alamat.regex' => 'Alamat harus mengandung setidaknya satu huruf.',
        ]);

        try {
            SiswaModel::create([
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'no_tlp' => $request->no_tlp,
                'alamat' => $request->alamat,
            ]);

            return redirect('/siswa')->with('success', 'Data siswa baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect('/siswa')->with('error', 'Data siswa baru gagal ditambahkan.');
        }
    }

    // Method hapus siswa
    public function siswahapus($id_swa)
    {
        $siswa = SiswaModel::where('id_swa', $id_swa)->first();

        if (!$siswa) {
            return redirect('/siswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Cek apakah siswa memiliki buku yang belum dikembalikan
        $peminjamanTerkait = PeminjamanModel::where('id_bku', $id_bku)->exists();

        if ($peminjamanTerkait) {
            return redirect('/siswa')->with('error', 'Data siswa ini tidak dapat dihapus karena masih memiliki peminjaman terkait.');
        }

        try {
            $siswa->delete();
            return redirect('/siswa')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/siswa')->with('error', 'Data siswa gagal dihapus.');
        }
    }

    // Method edit siswa
    public function siswaedit($id_swa, Request $request)
    {
        $siswa = SiswaModel::where('id_swa', $id_swa)->first();

        if (!$siswa) {
            return redirect('/siswa')->with('error', 'Data siswa tidak ditemukan!');
        }

        // Cek apakah siswa memiliki buku yang belum dikembalikan
        $peminjamanTerkait = PeminjamanModel::where('id_bku', $id_bku)->exists();

        if ($peminjamanTerkait) {
            return redirect('/siswa')->with('error', 'Data siswa ini tidak dapat diedit karena masih memiliki peminjaman terkait.');
        }

        $request->validate([
            'nama' => [
            'required',
            Rule::unique('siswa', 'nama')->ignore($siswa)
        ],
            'kelas' => 'required|numeric',
            'no_tlp' => 'required|numeric',
            'alamat' => 'required|string|regex:/[a-zA-Z]/'
        ], [
            'nama.required' => 'Nama siswa wajib diisi.',
            'nama.unique' => 'Nama siswa sudah ada, silakan gunakan nama yang berbeda.',
            'nama.regex' => 'Nama siswa harus mengandung setidaknya satu huruf.',
            'kelas.required' => 'Kelas siswa wajib diisi.',
            'kelas.numeric' => 'Kelas siswa harus berupa angka.',
            'no_tlp.required' => 'Nomor telepon wajib diisi.',
            'no_tlp.numeric' => 'Nomor telepon harus berupa angka.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa string.',
            'alamat.regex' => 'Alamat harus mengandung setidaknya satu huruf.',
        ]);

        try {
            $siswa->update([
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'no_tlp' => $request->no_tlp,
                'alamat' => $request->alamat,
            ]);

            return redirect('/siswa')->with('success', 'Data siswa berhasil diedit.');
        } catch (\Exception $e) {
            return redirect('/siswa')->with('error', 'Data siswa gagal diedit.');
        }
    }
}
