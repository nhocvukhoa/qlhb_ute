<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'thongbao_ten', 'thongbao_mota','thongbao_noidung', 'thongbao_file', 'thongbao_thoigiandang', 
        'thongbao_thoigiancapnhat', 'user_id'
    ];
    protected $primaryKey = 'thongbao_id';
    protected $table = 'thongbao';

    
}
