<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisableModel extends Model
{
    use HasFactory;
    protected $table = "disable";
    protected $fillable = [
        'ip'
    ];
}
