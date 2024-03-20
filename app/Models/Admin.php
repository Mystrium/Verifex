<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable {
    use HasFactory;

    public $timestamps = false;

    protected $table = 'admins';

    protected $fillable = [
        'pib',
        'phone',
        'password',
        'role',
        'allowed'
    ];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];
}
