<?php

namespace Mkhodroo\Cities\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $table = "province";
    protected $fillable = [
        'name', 'code'
    ];

}
