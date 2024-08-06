<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_swa';

    protected $fillable = [
        'nama',
        'kelas',
        'no_tlp',
        'alamat'
    ];

}
