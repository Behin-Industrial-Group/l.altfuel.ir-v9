<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinInfo extends Model
{
    use HasFactory;
    public $table = 'fin_info';
    protected $fillable = [
        'agency_table', 'agency_id', 'name', 'price', 'ref_id', 'pay_date', 'description', 'document'
    ];
}
