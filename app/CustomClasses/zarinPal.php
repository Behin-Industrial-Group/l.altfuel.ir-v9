<?php 

namespace App\CustomClasses;

use Illuminate\Http\Request;
use SoapClient;

class zarinPal
{
    public static function pay($request)
    {
        $MerchantID = 'cdc4e79d-ff6e-4684-ab94-8d74049ef5c9';
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
        $MerchantID = 'cdc4e79d-ff6e-4684-ab94-8d74049ef5c9';
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