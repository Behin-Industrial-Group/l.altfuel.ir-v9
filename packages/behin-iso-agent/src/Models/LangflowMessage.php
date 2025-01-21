<?php

namespace IsoAgent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LangflowMessage extends Model
{

    use HasFactory;

    protected $table = 'langflow_messages';

    protected $fillable = [
        'user_id',
        'message',
        'response',
    ];
}
