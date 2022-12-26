<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelakkhanModel extends Model
{
    protected $table= "pelakkhan";
    protected $fillable = [
        'CodeEtehadie', 'Receiver', 'Batch', 'PlateReader', 'DeliveryReceipts'
    ];
}
