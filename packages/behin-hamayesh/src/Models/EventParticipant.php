<?php

namespace Behin\Hamayesh\Models;

use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    protected $guarded = ['id'];
    
    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}