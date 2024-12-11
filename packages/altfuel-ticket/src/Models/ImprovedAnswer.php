<?php

namespace Mkhodroo\AltfuelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImprovedAnswer extends Model
{
    use HasFactory;
    
    protected $fillable = ['question', 'answer'];

}
