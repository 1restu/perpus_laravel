<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryModel extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = [
        'id_swa',
        'nama_swa',
        'id_bku',
        'judul',
        'tanggal_pinjam',
        'tenggat_kembali',
        'tanggal_kembali',
        'denda',
    ];

    public $timestamps = false;
}