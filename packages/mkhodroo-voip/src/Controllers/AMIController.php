<?php

namespace Mkhodroo\Voip\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mkhodroo\Voip\Models\VoipInfo;

class AMIController extends Controller
{
    public static function index()
    {
        // AMI credentials
        $host = 'voip.altfuel.ir';  // Asterisk server IP address
        $port = 5038;         // AMI port
        $username = 'admin'; // AMI username
        $password = '943842443992'; // AMI password

        // Asterisk CLI command to run
        $command = 'sip show peers';

        // Establish a connection to the Asterisk AMI
        $socket = fsockopen($host, $port, $errno, $errstr, 1);
        stream_set_timeout($socket, 1);

        if (!$socket) {
            die("Unable to connect to Asterisk AMI: $errstr ($errno)");
        }

        // Authenticate with AMI
        fputs($socket, "Action: Login\r\n");
        fputs($socket, "Username: $username\r\n");
        fputs($socket, "Secret: $password\r\n\r\n");

        // Wait for the response
        while ($line = fgets($socket)) {
            echo $line;
            if (stristr($line, 'Authentication accepted')) {
                break;
            }
        }

        // Send the Asterisk CLI command
        fputs($socket, "Action: Command\r\n");
        fputs($socket, "Command: $command\r\n\r\n");

        // Read and display the response
        $data = [];
        while ($line = fgets($socket)) {
            echo $line;
            if (is_numeric(substr($line, 0, 1))) {
                $data[] = explode(" ", $line);
            } else {
            }
        }

        // Close the connection
        fclose($socket);
        return $data;

        foreach ($data as $key1 => $array) {
            foreach ($array as $key => $value) {
                if (empty($value)) {
                    unset($array[$key]);
                }
            }

            $data[$key1] = $array;
        }
        $response = [];
        foreach ($data as $key1 => $array) {
            $i = 0;
            foreach ($array as $key => $value) {
                $response[$key1][$i] = $value;
                $i++;
            }

            // $data[$key1] = $array;
        }
        return serialize($response);

    }

    public static function test(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://voip.altfuel.ir/mkhodroo_pbxapi/test.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        $er = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        // $data = collect(unserialize($result));
        // print_r($data);
        // $onlineUsers = $data->where('71', 'OK');
        return $result;
    }
}
