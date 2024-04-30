<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrngvUsersInfo extends Model
{
    use HasFactory;
    protected $table = "irngv_users_info";
    protected $fillable = [
        'certificate_number', 'issued_date', 'owner_national_id', 'owner_fullname',
        'owner_mobile', 'customer_fullname' , 'customer_mobile', 'car_name', 'chassis',
        'plaque', 'agency_code', 'agency_name', 'poll_link', 'reg_type'
    ];
}
