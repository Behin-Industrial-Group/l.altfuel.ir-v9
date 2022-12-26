<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LableBuyingModel extends Model
{
    protected $table= "lablebuying";
    public $timestamps = false;
    protected $fillable = [
        'RefID', 'Markaz_ID', 'Package', 'startNo', 'endNo', 'Date'
    ];
}
