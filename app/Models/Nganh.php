<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nganh extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'khoa_id', 'nganh_ten'
    ];
    protected $primaryKey = 'nganh_id';
    protected $table = 'nganh';

    public function khoa(){
        return $this->belongsTo(Khoa::class);
    }

    public function lop() {
        return $this->hasMany(Lop::class);
    }
}
