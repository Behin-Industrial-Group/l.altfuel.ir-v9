<?php 

namespace Mkhodroo\AgencyInfo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgencyDebtPayment extends Model
{
    public $table = "agency_payments";
    protected $fillable = [
        'agency_info_row_id', 'price', 'authority', 'status', 'ref_id'
    ];

    // function role() {
    //     return 
    // }
}