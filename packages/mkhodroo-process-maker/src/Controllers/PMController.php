<?php 

namespace Mkhodroo\MkhodrooProcessMaker\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SoapClient;

class PMController extends Controller
{
    private static $pmServer;
    private static $pmWorkspace;

    public static function login() {
        $client = new SoapClient(env('PM_SERVER').'sysworkflow/en/neoclassic/services/wsdl2');
        $params = array(array('userid'=>'f.shahidi', 'password'=>'Fsh123456'));
        $result = $client->__SoapCall('login', $params);
        return $result;
    }

    public static function getAccessToken(){
        self::$pmServer = str_replace('https', 'http', env('PM_SERVER')) ;
        self::$pmWorkspace = "workflow";
        $postParams = array(
            'grant_type'    => 'password',
            'scope'         => '*',       //set to 'view_process' if not changing the process
            'client_id'     => env('PM_CLIENT_ID'),
            'client_secret' => env('PM_CLIENT_SECRET'),
            'username'      => env('PM_ADMIN_USER'),
            'password'      => env('PM_ADMIN_PASS')
        );
        $ch = curl_init(self::$pmServer . '/'. self::$pmWorkspace . "/oauth2/token");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $oToken = json_decode(curl_exec($ch));
        Log::info(curl_error($ch));
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpStatus != 200) {
            Log::info("Error in HTTP status code: $httpStatus\n");
        }
        elseif (isset($oToken->error)) {
            Log::info("Error logging into " . self::$pmServer .":\n" .
                "Error:       {$oToken->error}\n" .
                "Description: {$oToken->error_description}\n");
        }
        else {
            return $oToken->access_token;
        }
        
        return $oToken;
    }

    public static function changePass($accessToken, $userId, $newPass){
        $postParams = array(
            'usr_new_pass'      => $newPass,
            'usr_cnf_pass' => $newPass
          );
          
          $ch = curl_init(self::$pmServer . "/api/1.0/workflow/user/" . $userId);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $accessToken"));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postParams));
          $oResult = json_decode(curl_exec($ch));
          $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);

          
          if (isset($oResult) and isset($oResult->error)) {
             print "Error in ".self::$pmServer.": \nCode: {$oResult->error->code}\nMessage: {$oResult->error->message}\n";
             return null;
          }
          elseif ($statusCode != 200) {
            Log::info("Error updating user: HTTP status code: $statusCode\n");
            return null;
          }
          else {
             return true;
          }
    }

    public static function getUserId($accessToken){
        $username = Auth::user()->pm_username;
        $ch = curl_init(self::$pmServer . "/api/1.0/workflow/users?filter=$username");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $aUsers = json_decode(curl_exec($ch));
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $aActiveUsers = array();

        if ($statusCode != 200) {
        if (isset ($aUsers) and isset($aUsers->error))
            Log::info("Error code: {$aUsers->error->code}\nMessage: {$aUsers->error->message}\n");
        else
            Log::info("Error: HTTP status code: $statusCode\n");
        }
        else {
            return $aUsers[0]->usr_uid;
            foreach ($aUsers as $oUser) {
                if ($oUser->usr_status == "ACTIVE") {
                    $aActiveUsers[] = array("uid" => $oUser->usr_uid, "username" => $oUser->usr_username);
                }
            }
        }
    }
}