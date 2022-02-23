<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nganh_id', 'lop_ten' 
    ];
    protected $primaryKey = 'lop_id';
    protected $table = 'lop';

    public function nganh(){
        return $this->belongsTo(Nganh::class);
    }

    public function user() {
        return $this->hasMany(User::class);
    }
}
