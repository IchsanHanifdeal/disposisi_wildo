<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;
    protected $table = 'surat_keluar';
    protected $fillable = ['no_urut', 'tanggal_keluar', 'jenis_surat', 'tujuan', 'perihal', 'file'];
}
