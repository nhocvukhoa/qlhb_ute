<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoSoDangKy extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'dangky_id', 'tieuchi_id', 'hoso_hinhanh', 'hoso_ghichu' 
    ];
    protected $primaryKey = 'hoso_id';
    protected $table = 'hosodangky';
}
