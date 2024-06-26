<?php

namespace UserProfile\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileVerification extends Model
{
    use HasFactory;

    public $table = "verification_codes";

    protected $fillable = [
        'user_id', 'verification_code', 'expiration_date'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
