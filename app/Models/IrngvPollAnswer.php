<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrngvPollAnswer extends Model
{
    use HasFactory;
    protected $table = "irngv_poll_answers";
    protected $fillable = [
        'irngv_user_id', 'question', 'answer'
    ];
}
