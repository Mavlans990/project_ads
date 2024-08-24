<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'tb_karyawan';
    
    protected $primaryKey = 'nmr_induk';
    protected $fillable = [
        'nmr_induk',
        'nama',
        'alamat',
        'tgl_lahir',
        'tgl_bergabung',
    ];

    // protected $casts = [
    //     'tgl_lahir' => 'date',
    //     'tgl_bergabung' => 'date',
    // ];

    protected $casts = [
        'nmr_induk' => 'string'
    ];

    public function getcuti()
    {
        return $this->hasMany(Cuti::class, 'nmr_induk', 'nmr_induk');
    }
}
