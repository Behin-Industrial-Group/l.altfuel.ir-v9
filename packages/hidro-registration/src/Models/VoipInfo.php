<?php

namespace Mkhodroo\Voip\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoipInfo extends Model
{
    use HasFactory;
    public $table = 'voip_info';
    protected $fillable = [
        'user_id', 'key', 'value'
    ];
}
