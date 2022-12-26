<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssuesModel extends Model
{
    protected $table = 'issues';
    protected $fillable = [
        'name', 'catagory', 'NationalID', 'cellphone', 'issue', 'file', 'status'
    ];
}
