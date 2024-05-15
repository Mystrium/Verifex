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
        'role_id',
        'allowed'
    ];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function role() {
        return $this->belongsTo(Roles::class);
    }

    public function hasAccess($access){
        return $this->role->accesses->contains('slug', $access);
    }
}
