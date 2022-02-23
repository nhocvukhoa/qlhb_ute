<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diem extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'diem_hocky', 'diem_masv', 'diem_tensv', 'diem_ngaysinh', 'diem_khoa', 'diem_nganh', 'diem_lop',
        'diem_tinchi', 'diem_thang4', 'diem_thang10', 'diem_renluyen', 'diem_loaihocluc', 'diem_loairenluyen'
    ];
    protected $primaryKey = 'diem_id';
    protected $table = 'diem';
}
