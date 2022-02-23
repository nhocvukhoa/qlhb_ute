<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiHocBong extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'loaihocbong_ten'
    ];
    protected $primaryKey = 'loaihocbong_id';
    protected $table = 'loaihocbong';
}
