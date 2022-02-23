<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinhVienCanBo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'hocky', 'masinhvien', 'tensinhvien', 'ngaysinh', 'khoa', 'nganh', 'lop', 'chucvu', 'diemthuong',
        
    ];
    protected $primaryKey = 'id';
    protected $table = 'sinhviencanbo';
}
