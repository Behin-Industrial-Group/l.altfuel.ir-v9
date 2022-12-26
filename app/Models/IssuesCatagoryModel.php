<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssuesCatagoryModel extends Model
{
    protected $table = 'issues_catagory';
    protected $fillable = [
        'name', 'fa_name'
    ];
}
