<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssuesRobotCasesModel extends Model
{
    protected $table = 'issues_robot_cases';
    protected $fillable = [
        'name', 'value', 'parent_id'
    ];
}
