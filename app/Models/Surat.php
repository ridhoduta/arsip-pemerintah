<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    /** @use HasFactory<\Database\Factories\SuratFactory> */
    use HasFactory;
    protected $table = 'tb_surat';
    protected $primaryKey = 'surat_id';

    protected $fillable = [
        'nomor_surat',
        'kategori_id',
        'judul',
        'file',
    ];

    // Relasi: surat milik 1 kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }
}
