<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractorsModel extends Model
{
    protected $table = "contractors";
    protected $fillable = [
        'name', 'nationalId', 'phone','address'
    ];
}
