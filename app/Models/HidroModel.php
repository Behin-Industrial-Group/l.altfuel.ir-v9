<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HidroModel extends Model
{
    protected $table = "hidro";
    public $timestamps = false;
    protected $fillable = [
        'NationalID', 'Name', 'Province', 'City', 'CodeEtehadie', 'GuildNumber', 'IssueDate', 'ExpDate',
        'PostalCode', 'Cellphone', 'Tel', 'Address', 'MembershipFee96', 'MembershipFee97', 'MembershipFee98',
        'IrngvFee', 'LockFee', 'FinGreen', 'Location', 'Details', 'FinDetails', 'InsUserDelivered', 'DeliveryReceipts'
    ];
}
