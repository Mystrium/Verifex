<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleItem extends Model {
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'role_items';

    protected $fillable = [
        'role_id', 
        'item_id'
    ];

}
