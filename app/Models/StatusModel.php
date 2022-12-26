<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    protected $table= "status";
    public $timestamps = false;
    protected $fillable = [
        'status', 'catagory', 'tracking	',
    ];
}
