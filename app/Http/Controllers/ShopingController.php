<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zarinpal\Zarinpal;
use SoapClient;
use verta;
use App\LableBuyingModel;

class ShopingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $package = $request->input('package');
        $name = $request->input('name');
        $code = $request->input('code');

        switch($package)
        {
            case 0.5:
                $package = 0.5;
                break;
            case 1:
                $package = 1;
                break;
            case 2:
                $package = 2;
                break;
            default:
                $package = 0.5;
                break;                
        }

        $MerchantID = config('constants.zarinpal.shahab_MerchantID');
        $Amount = $package * 1000000;
        $Description = "$name - $code";
        $Mobile = $request->input('mobile');
        $CallbackURL = "http://label.altfuel.ir/shopinglable/verify?code=$code&package=$package";

        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest([
            'MerchantID'     => $MerchantID,
            'Amount'         => $Amount,
            'Description'    => $Description,
            'Mobile'         => $Mobile,
            'CallbackURL'    => $CallbackURL,
        ]);
    
        //Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {
            return redirect("https://www.zarinpal.com/pg/StartPay/$result->Authority");
        } else {
            return $result->Status;
        }
        
    }

    function verify(Request $request){
        $MerchantID = config('constants.zarinpal.shahab_MerchantID');
        $Amount = $request->get('package') * 1000; //Amount will be based on Toman
        $Code = $request->get('code');
        $Package = $request->get('package');
        $Authority = $request->get('Authority');

        $date = Verta();

        if ($_GET['Status'] == 'OK') {
            // URL also can be ir.zarinpal.com or de.zarinpal.com
            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
    
            $result = $client->PaymentVerification([
                'MerchantID'     => $MerchantID,
                'Authority'      => $Authority,
                'Amount'         => $Amount,
            ]);
    
            if ($result->Status == 100) {
                echo "<div class='alert alert-success text-center'>
                پرداخت موفق.
                شماره پیگیری: 
                $result->RefID;<br>
                <a href='http://lable.altfuel.ir'><button class='btn btn-info'>صفحه نخست</button></a>
                </div>";
                
                $insert = LableBuyingModel::create([
                    'RefID' => $result->RefID,
                    'Markaz_ID' => $Code,
                    'Package' => $Package,
                    'Date' => $date
                ]);

                if($insert)
                {
                    echo "ثبت شد";
                }
                else
                {
                    echo "ثبت نشد. لطفا با پشتیبانی تماس بگیرید.";
                }
                
            } else {
                echo "<div class='alert alert-danger text-center'>
                تراکنش ناموفق.
                علت: 
                $result->Status;<br>
                <a href='http://label.altfuel.ir'><button class='btn btn-info'>صفحه نخست</button></a>
                </div>";
            }
        } else {
            echo "<div class='alert alert-danger text-center'><b>
            تراکنش توسط کاربر لغو شد.<br>
            <a href='http://label.altfuel.ir'><button class='btn btn-info'>صفحه نخست</button></a>
            </b></div>";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
