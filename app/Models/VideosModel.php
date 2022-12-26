<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideosModel extends Model
{
    protected $table = 'learning_videos';
    protected $fillable = [
        'name', 'link', 'catagory', 'updated_at', 'created_at' 
    ];
}
