<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KamFesharModel extends Model
{
    protected $table = "kamfeshar";
    public $timestamps = false;
    protected $fillable = [
        'NationalID', 'Name', 'Province', 'City', 'CodeEtehadie', 'GuildNumber', 'IssueDate', 'ExpDate',
        'PostalCode', 'Cellphone', 'Tel', 'Address', 'MembershipFee96', 'MembershipFee97', 'MembershipFee98',
        'IrngvFee', 'LockFee', 'FinGreen', 'Location', 'Details', 'FinDetails', 'InsUserDelivered', 'DeliveryReceipts'
    ];
}
