<?php 

namespace Mkhodroo\UserRoles\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\UserRoles\Models\Access;
use Mkhodroo\UserRoles\Models\Method;

class GetMethodsController extends Controller
{
    public static function getByRoleAccess($role_id) {
        return Method::get()->each(function($row) use($role_id){
            $row->access = Access::where('role_id', $role_id)->where('method_id', $row->id)->first()?->access;
        });
    }

    public static function getAll() {
        return Method::get();
    }
}