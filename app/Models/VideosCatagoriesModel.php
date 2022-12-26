<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideosCatagoriesModel extends Model
{
    protected $table = 'learning_videos_catagories';
    protected $fillable = [
        'name', 'fa_name', 'updated_at', 'created_at' 
    ];
}
