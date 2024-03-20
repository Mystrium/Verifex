<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $table = 'items';

    protected $fillable = [
        'title', 
        'unit_id', 
        'hascolor', 
        'price', 
        'url_photo', 
        'url_instruction', 
        'description'
    ];

}
