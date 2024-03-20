<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consist extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $table = 'consists';

    protected $fillable = [
        'what_id', 
        'have_id',
        'count'
    ];

}
