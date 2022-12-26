<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileVerfication extends Model
{
    use HasFactory;
    protected $table = 'mobile_verificaion';
    protected $fillable = [
        'mobile', 'code'
    ];
}
