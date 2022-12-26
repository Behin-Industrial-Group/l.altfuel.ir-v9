<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveStatusModel extends Model
{
    protected $table= "ArchiveStatus";
    public $timestamps = false;
    protected $fillable = [
        'archive_id', 'Status_id', 'LetterNo', 'Date',
    ];
}
