<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHour extends Model {
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'work_hours';

    protected $fillable = [
        'worker_id', 
        'start',
        'stop'
    ];

}
