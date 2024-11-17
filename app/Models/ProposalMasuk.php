<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalMasuk extends Model
{
    use HasFactory;
    protected $table = 'proposal_masuk';
    protected $fillable = ['no_urut', 'tanggal_masuk', 'perihal', 'file'];
}
