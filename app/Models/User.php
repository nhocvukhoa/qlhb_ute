<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'quyen',
        'lop_id',
        'canbo',
        'chucdanh',
        'chucvu',
        'fullname',
        'diachi',
        'sdt',
        'gioitinh',
        'ngayDuyetTV',
        'tinhtrang',
        'ngaysinh',
        'khoa_id'
    ];

    public function getDueDateAttribute($namsinh) {
        return $namsinh->format('Y-m-d');
    }

    public function lop(){
        return $this->belongsTo(Lop::class);
    }

    public function hocbong()
    {
        return $this->belongsToMany(HocBong::class, 'DangKyHocBong', 'hocbong_id', 'user_id');
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
}
