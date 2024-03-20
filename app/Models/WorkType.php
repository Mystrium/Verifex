<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkType extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $table = 'work_types';

    protected $fillable = [
        'title', 
        'cehtype_id', 
        'min_pay'
    ];

}
