<?php 

namespace Mkhodroo\AgencyInfo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgencyInfo extends Model
{
    use SoftDeletes;
    public $table = "agency_info";
    protected $fillable = [
        'key', 'value', 'parent_id', 'desciption'
    ];

    // function role() {
    //     return 
    // }
}