<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveModel extends Model
{
    protected $table= "archive";
    public $timestamps = false;
    protected $fillable = [
        'name', 'codemeli', 'ostan', 'No', 'raste', 'cellphone', 'codemarkaz', 'lastreceiver'
    ];
}
