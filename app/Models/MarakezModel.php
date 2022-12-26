<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarakezModel extends Model
{
    protected $table = 'marakez1';
    public $timestamps = false;
    protected $fillable = [
        'NationalID', 'Name', 'Province', 'City', 'CodeEtehadie', 'GuildNumber', 'IssueDate', 'ExpDate',
        'PostalCode', 'Cellphone', 'Tel', 'Address', 'MembershipFee96', 'MembershipFee97', 'MembershipFee98',
        'MembershipFee99', 'MembershipFee00', 'debt', 'debt_RefID', 'dept_description',
        'IrngvFee', 'LockFee', 'FinGreen', 'Location', 'Details', 'FinDetails', 'InsUserDelivered', 'DeliveryReceipts'
    ];

}
