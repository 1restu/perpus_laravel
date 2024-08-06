<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BukuModel;
use App\Models\SiswaModel;

class PeminjamanModel extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjam';

    protected $fillable = [
        'id_swa',
        'id_bku',
        'tanggal_pinjam',
        'tenggat_kembali',
        'tanggal_kembali',
        'denda',
        'status'
    ];

    protected $dates = [
        'tanggal_pinjam', 'tenggat_kembali', 'tanggal_kembali'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relasi ke model Siswa
    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_swa', 'id_swa');
    }

    // Relasi ke model Buku
    public function buku()
    {
        return $this->belongsTo(BukuModel::class, 'id_bku', 'id_bku');
    }
}
