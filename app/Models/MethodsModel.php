<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MethodsModel extends Model
{
    protected $table = 'methods';
    public $timestamps = false;
    protected $fillable = [
        'name', 'fa_name', 
    ];
}
