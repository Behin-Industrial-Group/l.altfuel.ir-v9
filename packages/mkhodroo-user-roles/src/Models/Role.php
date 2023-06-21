<?php 

namespace Mkhodroo\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = "mkhodroo_roles";
    protected $fillable = [
        'name'
    ];

    // function role() {
    //     return 
    // }
}