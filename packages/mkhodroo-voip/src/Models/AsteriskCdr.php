<?php

namespace Mkhodroo\Voip\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsteriskCdr extends Model
{
    use HasFactory;
    protected $connection = 'cdr_mysql';
    public $table = 'cdr';
}
