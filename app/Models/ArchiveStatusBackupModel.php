<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveStatusBackupModel extends Model
{
    protected $table= "ArchiveStatus_backup";
    public $timestamps = false;
    protected $fillable = [
        'archive_id', 'Status_id', 'LetterNo', 'Date',
    ];
}
