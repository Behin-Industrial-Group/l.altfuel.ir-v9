<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallReportModel extends Model
{
    use HasFactory;
    protected $table = "calls_report";
    protected $fillable = [
        'ext', 'name', 'answer_percnet', 'answer_time', 'unanswer_percnet', 'unanswer_time', 'busy_percent', 'created_at'
    ];
}
