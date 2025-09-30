<?php

namespace Behin\Complaint\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use SoftDeletes;
    public $table = "complaint";
    protected $fillable = [
        'content'
    ];

    // function role() {
    //     return
    // }
}
