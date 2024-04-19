<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $table = 'transactions';

    protected $fillable = [
        'worker_from_id', 
        'worker_to_id', 
        'item_id_id', 
        'color_id',
        'count',
        'date'
    ];

}
