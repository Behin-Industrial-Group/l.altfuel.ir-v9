<?php 

namespace Mkhodroo\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    public $table = "mkhodroo_access";
    protected $fillable = [
        'role_id', 'method_id', 'access'
    ];

    function role() {
        return Role::find($this->role_id);
    }

    function method() {
        return Method::find($this->method_id);
    }
}