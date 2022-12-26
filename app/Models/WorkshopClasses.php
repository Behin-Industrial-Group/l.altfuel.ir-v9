<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopClasses extends Model
{
    use HasFactory;
    protected $table = 'workshop_classes';
    protected $fillable = [
        'title', 'day', 'time', 'end_time', 'motevali', 'teacher', 'capacity', 'code'
    ];
}
