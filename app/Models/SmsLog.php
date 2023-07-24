<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;
    protected $table = "sms_log";
    protected $fillable = [
        'user', 'to', 'text'
    ];

    public static function set($user = null, $to, $text) {
        SmsLog::create([
            'user' => $user,
            'to' => $to,
            'text' => $text
        ]);
    }
}
