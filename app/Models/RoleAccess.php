<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model {
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'role_access';

    protected $fillable = [
        'role_id', 
        'access_id'
    ];

}
