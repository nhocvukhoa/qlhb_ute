<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamHoc extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'namhoc_ten', 'namhoc_thoigianbatdau', 'namhoc_thoigianketthuc'
    ];
    protected $primaryKey = 'namhoc_id';
    protected $table = 'namhoc';
}
