<?php

namespace Mkhodroo\SmsTemplate\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendSmsController extends Controller
{
    private $url;
    private $user;
    private $pass;
    private $org;

    public function __construct() {
        $this->url = 'https://payamsms.com/services/rest/index.php';
        $this->org = 'irngv';
        $this->user = 'irngv';
        $this->pass = 'irngv123';
    }

    public function send($to, $msg)
    {

        // $msg += "\n اتحادیه ملی سوختهای جایگزین";
        $response = Http::withHeaders([
            'X-API-KEY' => env('SMS_TOKEN'),
        ])->post('https://iran.altfuel.ir/sms/index.php', [
            'to' => $to,
            'message' => $msg
        ]);
        Log::info($response);
        if ($response->successful()) {
            echo $response->body(); // یا log کن یا ذخیره کن
        } else {
            echo "خطا در ارسال SMS";
        }
    }

    public function send_multiple(array $messages)
    {
        $data = array(
            'organization' => $this->org,
            'username' => $this->user,
            'password' => $this->pass,
            'method' => 'send',
            'messages' => $messages
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        # Setup request to send json via GET.
        $payload = json_encode($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);

        # Return response instead of printing.
        # Send request.
        $er = curl_error($ch);
        if($er)
            Log::info("send sms curl error: $er ");
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        if(isset($result->data[0]->serverId))
            return 'ok';
        return $result;
    }

}
