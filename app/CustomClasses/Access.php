<?php

namespace App\CustomClasses;

use App\Models\AccessModel;
use App\Models\MethodsModel;
use App\Models\DisableModel;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mkhodroo\UserRoles\Controllers\AccessController;

class Access
{
    public static function set($user_id,$method_name)
    {
        $method = MethodsModel::where('name',$method_name)->first();
        $access = AccessModel::where('user_id',$user_id)->where('method_id',$method->id)->first();

        if($access)
            AccessModel::where('user_id',$user_id)->where('method_id',$method->id)->update(['access' => 'yes']);
        else
            AccessModel::create([
                'user_id' => $user_id,
                'method_id' => $method->id,
                'access' => 'yes',
                ]);
    }

    public static function unset($user_id,$method_name)
    {
        $method = MethodsModel::where('name',$method_name)->first();
        $access = AccessModel::where('user_id',$user_id)->where('method_id',$method->id)->first();

        if($access)
            AccessModel::where('user_id',$user_id)->where('method_id',$method->id)->update(['access' => null]);
        else
            AccessModel::create([
                'user_id' => $user_id,
                'method_id' => $method->id,
                'access' => null,
                ]);
    }

    public static function check($method_name)
    {
        try{
            $a = new AccessController($method_name);
            if(!$a->check()){
                return abort(403, "Forbidden For : " . $method_name);
            }
            // $method = MethodsModel::firstOrCreate(['name' => $method_name]);
            // $user = Auth::user();
            // $access = AccessModel::where('method_id', $method->id)->where('user_id', $user->id)->first();

            // if(!empty($access)):
            //     if($access->access == 'yes'):
            //         return true;
            //     else:
            //         //return false;
            //         abort(403);
            //     endif;
            // else:
            //     abort(403);
            // endif;
        }
        catch(Exception $e){
            abort(403,$e->getMessage());
        }

    }

    public static function checkView($method_name)
    {
        try{
            $a = new AccessController($method_name);
            if(!$a->check()){
                return false;
            }
            // $method = MethodsModel::firstOrCreate(['name' => $method_name]);
            // $user = Auth::user();
            // $access = AccessModel::where('method_id', $method->id)->where('user_id', $user->id)->first();

            // if(!empty($access)):
            //     if($access->access == 'yes'):
            //         return true;
            //     else:
            //         //return false;
            //         return false;
            //     endif;
            // else:
            //     return false;
            // endif;
        }
        catch(Exception $e){
            return false;
        }
    }

    public static function create($method_name,$method_faname)
    {
        $method = new MethodsModel();
        $method->name = $method_name;
        $method->fa_name = $method_faname;
        $method->save();
        return true;
    }

    public function CheckClientIP()
    {
        // $clientip = ($_SERVER['REMOTE_ADDR']);
        // if(DisableModel::get()->count()){
        //     if(!DisableModel::where('ip', $clientip)->count()){
        //         abort(403,'نرم افزار جهت بروز رسانی در دسترس نمی باشد');
        //     }
        // }
    }
}
