<?php

namespace BehinTest\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BehinTest extends Model
{
    use HasFactory;
    protected $connection = "mysqlTest";
    public $table = 'altfuel_ticket_comments';
    protected $fillable = [
        'ticket_id', 'user_id', 'text'
    ];

}
