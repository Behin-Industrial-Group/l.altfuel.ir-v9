<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceModel extends Model
{
    protected $table= "insurance";
    public $timestamps = false;
    protected $fillable = [
        'RefID', 'markaz_id', 'price', 'productType', 'number' , 'startNo', 'endNo', 'updated_at', 'created_at'
    ];
}
