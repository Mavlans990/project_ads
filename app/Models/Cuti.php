<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'tb_cuti';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nmr_induk',
        'tgl_cuti',
        'lama_cuti',
        'keterangan',
    ];

    protected $dates = ['tgl_cuti'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nmr_induk', 'nmr_induk');
    }
}
