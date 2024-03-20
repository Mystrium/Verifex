<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ceh extends Model {
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'ceh';

    protected $fillable = ['type_id', 'title'];

}
