<?php

namespace Mkhodroo\Voip\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallHistory extends Model
{
    use HasFactory;
    public $table = 'call_history';
    protected $fillable = [
        'ext_num', 'from', 'status', 'duration'
    ];
}
