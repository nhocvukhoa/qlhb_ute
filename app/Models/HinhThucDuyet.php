<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HinhThucDuyet extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'hinhthucduyet_ten'
    ];
    protected $primaryKey = 'hinhthucduyet_id';
    protected $table = 'hinhthucduyet';
}
