<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\MarakezModel;
use App\InsuranceModel;
use App\TakmiliModel;
use App\TakafolModel;
use App\CustomClasses\zarinPal;
use App\CustomClasses\Access;
use Verta;

class BimehController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marakez  = MarakezModel::get();
        return view('bimeh.index')->with([ 'marakez' => $marakez ]);
    }

    public function calculatePrice(Request $request)
    {
        switch($request->insType){
            case 1:
                $unitPrice = 5000;
                $product = "فقط بیمه مسولیت";
                break;
            case 2:
                $unitPrice = 50000;
                $product = "بیمه مسولیت و تضمین کیفیت";
                break;
            default:
                $unitPrice = 5000;
                $product = "فقط بیمه مسولیت";
                break;
        }
        
        switch( $request->number ){
            case 1:
                $number = 25;
                break;
            case 2:
                $number = 50;
                break;
            default:
                $number = 25;
                break;
        }
         
        $description = $number . "-" . $product . "-" . $request->CodeEtehadie;    
        $price = $unitPrice * $number;
        
        $paymentInformation = [
            'number' => $number,
            'productType' => $request->insType,
            'productName' => $product,
            'purchaser' => $request->CodeEtehadie,
            'description' => $description,
            'mobile' => $request->mobile,
            'price' => $price,
            ];
            
        //return $paymentInformation;
        return view( 'bimeh.price' )->with( [ 'paymentInfo' => $paymentInformation ] );
    }
    
    public function pay(Request $request)
    {
        $payInfo = [
            'amount' => $request->amount,
            'description' => $request->description,
            'mobile' => $request->mobile,
            'callbackUrl' => $request->callbackUrl,
            ];
        $result = zarinPal::pay($payInfo);
        if($result == false)
            return "not success";
    }
    
    public function success(Request $request, $codeEtehadie, $price, $pType, $number)
    {
        $result = zarinPal::verify($request, $price);
        
        if( $result == 0 ){
            $message = "پرداخت ناموفق";
            return view( 'bimeh.unsuccess' )-> with( [ 'message' => $message ] );
        }
        elseif($result == 1){
            $message = "تراکنش توسط کاربر لغو شد";
            return view( 'bimeh.unsuccess' )-> with( [ 'message' => $message ] );
        }
        else
        {
            $row = new InsuranceModel();
            $row->markaz_id = $codeEtehadie;
            $row->RefID = "$result";
            $row->price = $price;
            $row->productType = $pType;
            $row->number = $number;
            
            $date = Verta();
            $row->updated_at = $date;
            $row->created_at = $date;
            
            $row->save();
            
            $successfulPayInfo = [
                'codeEtehadie' => $codeEtehadie,
                'RefID' => $result,
                'price' => $price,
                'date' => $date,
                ];
            
            return view( 'bimeh.success' )->with( [ 'successfulPayInfo' => $successfulPayInfo] );
        }
    }
    
    // TAKMILI METHODS
    public function registerForm()
    {
        return view('takmili.registerform');
    }
    
    public function register(Request $r)
    {
        $checkNationalID = $this->isValidIranianNationalCode($r->national_id);

        if($checkNationalID == false){
            $message = "کدملی نامعتبر است";
            return redirect()->route('takmiliform', [ 'message' => $message ])->withInput();
        }
        
        $validate = \Validator::make($r->all(),
            [
            'national_id' => [ 'required' ],
            'fname' => [ 'required' ],
            'lname' => [ 'required' ] ,
            'father' => [ 'required' ] ,
            'dateopened_d' => [ 'required' ],
            'dateopened_m' => [ 'required' ],
            'dateopened_y' => [ 'required' ],
            'gender' => [ 'required' ] ,
            'mobile' => [ 'required' ] ,
            'tel' => [ 'required' ] ,
            'postalCode' => [ 'required' ] ,
            'address' => [ 'required' ],
            'bank' => [ 'required' ] ,
            'sheba' => [ 'required' ] ,
            'plan' => [ 'required' ] ,
            'acc' => [ 'required' ] ,
            ]);
            
        if($validate->fails())
            return redirect()->back()->withInput()->withErrors($validate);
            
        
        
        $person = TakmiliModel::where( 'national_id', $r->national_id )->get();
        
        $dateopened = $r->dateopened_y . "-" . $r->dateopened_m . "-" . $r->dateopened_d ;
        
        foreach($person as $p){
            if($p->RefID == null)
                TakmiliModel::where( 'id', $p->id )->delete();
            else{
                $message = "این کد ملی قبلا ثبت شده است";
                return view( 'takmili.registerform' )->with([ 'message' => $message ]);
            }
        }
        
        $key = $r->national_id . rand(1000000,9999999);
        $date = Verta();
        $numberOfTakafolPerson = 0;
        $i = count($r->takafol_fname);
        for($num=0; $num < $i; $num++)
        {
            if($r->takafol_fname[$num])
                $numberOfTakafolPerson++;
        }
        
        if(isset($r->acc))
            $acc = 'agree';
        
        $relation = "اصلی";
        $gender = $this->checkGender($r->gender);
        
        $markaz = TakmiliModel::updateOrCreate(
            [ 'national_id' => $r->national_id ],
            [
                'randkey' => $key,
                'fname' => $r->fname ,
                'lname' => $r->lname ,
                'birthCertificateNumber' => $r->birthCertificateNumber,
                'father' => $r->father ,
                'dateopened' => $dateopened ,
                'gender' => $gender ,
                'mobile' => $r->mobile ,
                'tel' => $r->tel ,
                'takafol_relation' => $relation ,
                'takafol_fname' => $r->fname ,
                'takafol_lname' => $r->lname ,
                'takafol_birthDate' => $dateopened ,
                'takafol_nationalID' => $r->national_id,
                'takafol_birthCertificateNumber' => $r->birthCertificateNumber ,
                'takafol_father' => $r->father ,
                'takafol_gender' => $gender ,
                'postalCode' => $r->postalCode ,
                'address' => $r->address ,
                'bank' => $r->bank ,
                'sheba' => $r->sheba ,
                'plan' => $r->plan ,
                'acc' => $acc ,
                'numberOfTakafolPerson' => $numberOfTakafolPerson ,
                'updated_at' => $date ,
                'created_at' => $date ,
                ]
            );
        
        for($n=0; $n<$numberOfTakafolPerson ; $n++)
        {
            $checkNationalID = $this->isValidIranianNationalCode($r->takafol_nationalID[$n]);

            if($checkNationalID == false){
                $m = $n+1;
                $message = "کدملی فرد تحت تکفل "
                . $m .
                "نامعتبر است";
                return redirect()->route('takmiliform', [ 'message' => $message ])->withInput();
            }
            
            $person = TakmiliModel::where( 'takafol_nationalID', $r->takafol_nationalID[$n] )->first();
            if( !is_null($person) ){
                $message = "کدملی حداقل دو نفر در فرم تکراری است";
                return redirect()->route('takmiliform', [ 'message' => $message ])->withInput();
            }
            
            $takafol_relation = $this->checkRelation($r->takafol_ralation[$n]);
            $takafol_birthDate = $r->takafol_birthDate_y[$n] ."-". $r->takafol_birthDate_m[$n] ."-". $r->takafol_birthDate_d[$n];
            $takafol_gender = $this->checkGender($r->takafol_gender[$n]);
        
            $markaz = TakmiliModel::updateOrCreate(
                [ 
                    'takafol_nationalID' => $r->takafol_nationalID[$n],
                    'national_id' => $r->national_id,  
                ],
                [
                    'randkey' => $key,
                    'takafol_relation' => $takafol_relation ,
                    'takafol_fname' => $r->takafol_fname[$n] ,
                    'takafol_lname' => $r->takafol_lname[$n] ,
                    'takafol_birthDate' => $takafol_birthDate ,
                    'takafol_birthCertificateNumber' => $r->takafol_birthCertificateNumber[$n] ,
                    'takafol_father' => $r->takafol_father[$n] ,
                    'takafol_gender' => $takafol_gender ,
                    'updated_at' => $date ,
                    'created_at' => $date ,
                    ]
                );
        }
        
        switch($r->plan)
        {
            case 'plan1':
                $unitPrice = 1360000;
                break;
            case 'plan2':
                $unitPrice = 1000000;
                break;
            case 'plan3':
                $unitPrice = 700000;
                break;
        }
        
        $price = ($numberOfTakafolPerson + 1) * $unitPrice;
        
        $description = "خرید بیمه تکمیلی - کدملی: "
        . $r->national_id . " - ".
        "تعداد افراد تحت تکفل: "
        . $numberOfTakafolPerson . " - " .
        "نوع طرح: "
        .$r->plan
        ;
        /*
        $payInfo = [
            'amount' => $price,
            'description' => $description,
            'mobile' => $r->mobile,
            'callbackUrl' => Url("/takmili/success/$key/$price"),
            ];
        
        
        $result = zarinPal::pay($payInfo);
        if($result == false)
            return "not success";
        */
        return $this->takmiliSuccess();
    }
    
    public function takmiliSuccess(Request $request=null, $key=null, $price=null)
    {
        /*
        $result = zarinPal::verify($request, $price);
        $date = Verta();
        
        if( $result == 0 ){
            $message = "پرداخت ناموفق";
            return view( 'takmili.unsuccess' )-> with( [ 'message' => $message ] );
        }
        elseif($result == 1){
            $message = "تراکنش توسط کاربر لغو شد";
            return view( 'takmili.unsuccess' )-> with( [ 'message' => $message ] );
        }else{
            $numberOfPerson = TakmiliModel::where( 'randkey', $key )->count();
            $pricePerPerson = $price / $numberOfPerson;
            
            TakmiliModel::where( 'randkey' , $key )->update([
                'RefID' => "$result",
                'price' => $pricePerPerson,
                'updated_at' => $date,
                ]);
            $no = TakmiliModel::where( 'randkey', $key )->whereNotNull('RefID')->count();
            
            $successfulPayInfo = [
                'numberOfPay' => $no,
                'RefID' => "$result",
                'price' => $price,
                'date' => $date,
                ];
                */
            return view( 'takmili.success' );
        //}
    }
    
    public function showAll()
    {
        Access::check( 'Bimeh_showAll' );
        $registerors = TakmiliModel::orderby('national_id')->orderby('takafol_relation')->get();
        
        return view( 'takmili.registerors' )->with( [ 'registerors' => $registerors ] );
    }
    
    public function loginForm()
    {
        return view( 'takmili.login' );
    }
    
    public function show(Request $r)
    {
        $username = "user1";
        $pass = "zv8x7155";
        if( $r->username !=  $username && $r->password != $pass)
        {
            $error = "نام کاربری و رمز عبور اشتباه است";
            return view( 'takmili.login' )->with( [ 'error' => $error ] );
        }
        
        $registerors = TakmiliModel::orderby('national_id')->orderby('takafol_relation')->get();
        
        return view( 'takmili.registerors' )->with( [ 'registerors' => $registerors ] );
    }
    
    private function isValidIranianNationalCode($input) {
        if (!preg_match("/^\d{10}$/", $input)) {
            return false;
        }
    
        $check = (int) $input[9];
        $sum = array_sum(array_map(function ($x) use ($input) {
            return ((int) $input[$x]) * (10 - $x);
        }, range(0, 8))) % 11;
    
        return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
    }
    
    private function checkRelation($value){
        switch($value){
                case 1:
                    $text = "همسر";
                    break;
                case 2:
                    $text = "پدر";
                    break;
                case 3:
                    $text = "مادر";
                    break;
                case 4:
                    $text = "فرزند اول";
                    break;
                case 5:
                    $text = "فرزند دوم";
                    break;
                case 6:
                    $text = "فرزند سوم";
                    break;
            }
        return $text;
    }
    
    private function checkGender($value){
        switch($value){
                case 'male':
                    $text = "مرد";
                    break;
                case 'female':
                    $text = "زن";
                    break;
                default :
                    $text = "مرد";
                    break;
            }
        return $text;
    }
}
