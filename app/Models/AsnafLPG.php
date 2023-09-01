<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsnafLPG extends Model
{
    use HasFactory;
    public $table = "asnaf_lpg_registerations";
    protected $fillable = [
        'fname', 'lname', 'nid', 'city_id', 'mobile', 'asnaf_catagory', 'monthly_use'
    ];
}
