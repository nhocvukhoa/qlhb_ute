<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruyCap extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'truycap_ip', 'truycap_ngay'
    ];
    protected $primaryKey = 'truycap_id';
    protected $table = 'truycap';
}
