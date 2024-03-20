<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $table = 'workers';

    protected $fillable = [
        'pib', 
        'ceh_id', 
        'role_id', 
        'phone', 
        'passport', 
        'password',
        'checked'
    ];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

}
