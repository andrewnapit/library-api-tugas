<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // Ini daftar kolom yang boleh diisi, harus sesuai dengan migration tadi
    protected $fillable = [
        'name',
        'member_code',
        'email',
        'phone',
        'address',
        'status',
        'joined_at'
    ];
}
