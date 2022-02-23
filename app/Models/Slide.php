<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'slide_ten', 'slide_hinhanh'
    ];
    protected $primaryKey = 'slide_id';
    protected $table = 'slide';
}
