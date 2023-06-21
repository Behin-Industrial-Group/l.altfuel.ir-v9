<?php 

namespace Mkhodroo\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    public $table = "mkhodroo_methods";
    protected $fillable = [
        'name', 'disable'
    ];

    // function role() {
    //     return 
    // }
}