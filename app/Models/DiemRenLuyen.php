<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DiemRenLuyen extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'diemrenluyen_hocky','diemrenluyen_msv', 'diemrenluyen_tensv', 'diemrenluyen_ngaysinh', 'diemrenluyen_khoa',
        'diemrenluyen_nganh', 'diemrenluyen_lop', 'diemrenluyen_diem', 'diemrenluyen_xeploai'
    ];
    protected $primaryKey = 'diemrenluyen_id';
    protected $table = 'diemrenluyen';

  

}
