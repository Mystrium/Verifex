<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model {
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'accesses';

    protected $fillable = ['title', 'slug'];

    public function roles(){
        return $this->belongsToMany(Roles::class, 'role_access', 'access_id', 'role_id');
    }

}
