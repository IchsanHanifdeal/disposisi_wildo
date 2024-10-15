<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalKeluar extends Model
{
    use HasFactory;
    protected $table = 'proposal_keluar';
    protected $fillable = ['no_urut', 'tanggal_keluar', 'perihal', 'file'];
}
