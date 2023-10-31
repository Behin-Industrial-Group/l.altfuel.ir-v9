<?php

namespace Mkhodroo\HelpSupportRobot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpSupport extends Model
{
    use HasFactory;
    public $table = 'help_support_robot';
    protected $fillable = [
        'key', 'value', 'parent_id', 'description'
    ];
    
}
