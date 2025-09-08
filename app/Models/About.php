<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    /** @use HasFactory<\Database\Factories\AboutFactory> */
    use HasFactory;
    protected $table = 'tb_about';
    protected $primaryKey = 'nim'; // karena nim yang unik

    protected $fillable = [
        'nama',
        'prodi',
        'nim',
        'tanggal_aplikasi',
    ];

    public $incrementing = false;
}
