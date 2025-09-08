<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriFactory> */
    use HasFactory;
    protected $table = 'tb_kategori';
    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'nama_kategori',
        'keterangan',
    ];

    // Relasi: 1 kategori punya banyak surat
    public function surat()
    {
        return $this->hasMany(Surat::class, 'kategori_id', 'kategori_id');
    }
}
