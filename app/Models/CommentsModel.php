<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentsModel extends Model
{
    protected $table= "comments";
    protected $fillable = [
        'table_name', 'record_id', 'comment',
    ];
}
