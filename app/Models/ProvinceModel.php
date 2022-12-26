<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvinceModel extends Model
{
    protected $table= "Province";
    public $timestamps = false;
    protected $fillable = [
        'Name', 'code'
    ];
}
