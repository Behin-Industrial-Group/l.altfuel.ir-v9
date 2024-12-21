<?php

namespace Registration\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'national_id', 'mobile', 'price', 'authority', 'status', 'ref_id'
    ];

}
