<?php

namespace Mkhodroo\AltfuelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mkhodroo\UserRoles\Models\User;

class ActorsTicketCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'actor_id', 'count'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

}
