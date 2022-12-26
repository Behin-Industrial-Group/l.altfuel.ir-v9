<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessModel extends Model
{
    protected $table = 'accessibility';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'method_id', 'access',
    ];
}
