<?php 

namespace App\CustomClasses;

use Illuminate\Http\Request;
use SoapClient;

class zarinPal
{
    public static function pay($request)
    {
        $MerchantID = '6a6243dd-534e-4ea5-9b42-0b2cf1da4a09';
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentRequest([
            'MerchantID'     => $MerchantID,
            'Amount'         => $request['amount'],
            'Description'    => $request['description'],
            'Mobile'         => $request['mobile'],
            'CallbackURL'    => $request['callbackUrl'],
        ]);
        
        if ($result->Status == 100) {
            return redirect('https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
        } else {
            return null;
        }

    }
    
    public static function verify(Request $request, $price)
    {
        $MerchantID = '6a6243dd-534e-4ea5-9b42-0b2cf1da4a09';
        if ($request->Status == 'OK') {
            // URL also can be ir.zarinpal.com or de.zarinpal.com
            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
    
            $result = $client->PaymentVerification([
                'MerchantID'     => $MerchantID,
                'Authority'      => $request->Authority,
                'Amount'         => $price,
            ]);
    
            if ($result->Status == 100) {
                return $result->RefID;
                
            }else {
                return 0;
            }
        }else{
            return 1;
        }
    }
}