<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HocBong extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'loaihocbong_id', 'hocky_id', 'hocbong_ten', 'hocbong_hinhanh', 'hocbong_file','hocbong_noidung', 'hocbong_thoigianbatdau',
        'hocbong_thoigianketthuc', 'hocbong_kinhphi', 'hocbong_tongsoluong', 'hocbong_soluongdadangky',
        'hocbong_tinhtrang', 'hocbong_nguoiduyet', 'user_id', 'hocbong_ngayduyet', 'hocbong_luotxem', 'hinhthucduyet_id'
    ];
    protected $primaryKey = 'hocbong_id';
    protected $table = 'hocbong';

    public function tieuchi() {
        return $this->belongsToMany(TieuChi::class, 'TieuChiHocBong', 'hocbong_id', 'tieuchi_id');
    }

    public function user() {
        return $this->belongsToMany(User::class, 'DangKyHocBong', 'user_id', 'hocbong_id');
    }
}
