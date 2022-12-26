<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RasteModel extends Model
{
    protected $table= "raste";
    protected $fillable = [
        'Name',
    ];
}
