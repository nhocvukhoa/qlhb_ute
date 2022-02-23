<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiemHocTap extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'diemhoctap_hocky','diemhoctap_msv', 'diemhoctap_tensv', 'diemhoctap_ngaysinh', 'diemhoctap_khoa',
        'diemhoctap_nganh', 'diemhoctap_lop', 'diemhoctap_tinchi', 'diemhoctap_thang4', 'diemhoctap_thang10', 
        'diemhoctap_xeploai'
    ];
    protected $primaryKey = 'diemhoctap_id';
    protected $table = 'diemhoctap';
}
