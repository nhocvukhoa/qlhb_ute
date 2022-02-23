<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class DangKyHocBong extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [''];
    protected $fillable = [
        'user_id', 'hocbong_id', 'user_name', 'user_fullname', 'user_nganh', 'user_lop',
        'dangky_thoigiandk', 'dangky_tinhtrang', 'dangky_ketqua','dangky_nguoiduyet', 'dangky_thoigianduyet'
    ];
    protected $primaryKey = 'dangky_id';
    protected $table = 'dangkyhocbong';

    public function getDangKyHocBong($hocbong_id) {

        return $this->select('dangky_id','user_name','user_fullname', 'user_nganh', 'user_lop')
        ->where('dangky_tinhtrang', '=', '1')
        ->where('hocbong_id', $hocbong_id)
        ->get();
    }
}
