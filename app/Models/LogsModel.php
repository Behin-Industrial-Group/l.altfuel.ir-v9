<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsModel extends Model
{
    protected $table= "logs";
    protected $fillable = [
        'user_id', 'act', 'table_name', 'record_id', 'column_name', 'descripe', 'updated_at', 'created_at'
    ];
}
