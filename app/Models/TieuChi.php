<?php

namespace App\Models;

use App\Http\Controllers\HocBongController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TieuChi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'tieuchi_ten'
    ];
    protected $primaryKey = 'tieuchi_id';
    protected $table = 'tieuchi';

    public function hocBong() {
        return $this->belongstoMany(HocBong::class, 'TieuChiHocBong', 'tieuchi_id', 'hocbong_id');
    }

}
