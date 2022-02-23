<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'khoa_id', 'khoa_ten' 
    ];
    protected $primaryKey = 'khoa_id';
    protected $table = 'khoa';

    public function nganh() {
        return $this->hasMany(Nganh::class);
    }
}
