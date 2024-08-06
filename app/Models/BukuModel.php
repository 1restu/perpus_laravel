<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuModel extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_bku';

    protected $fillable = [
        'judul',
        'penulis',
        'tahun_terbit',
        'penerbit',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
