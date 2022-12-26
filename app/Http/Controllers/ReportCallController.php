<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\IssuesModel;
use App\IssuesCatagoryModel;
use App\MarakezModel;
use File;
use Verta;
use App\Traits\reCAPTCHA;
use App\CustomClasses\IssuesCatagory;
use App\CustomClasses\Logs;
use App\CustomClasses\Access;
use App\CustomClasses\ExcelReader;
use SoapClient;
use App\User;
use App\LogsModel;


class ReportCallController extends Controller
{
    public function call(Request $request, $year = null)
    {
        $simplexlsx = new ExcelReader();
        
        echo '<h1>Parse books.xslx</h1><pre>';
        if ( $xlsx = $simplexlsx->parse('http://l.altfuel.ir/public/excel-reader/simplexlsx-master/examples/books.xlsx') ) {
        	print_r( $xlsx->rows() );
        } else {
        	echo $simplexlsx->parseError();
        }
        echo '<pre>';

        /*
        $new = json_encode($file);
        
        return var_dump($file);
        
        $number_of = [
            'agancy' => [ 'no'=> 0 , 'name'=>'خدمات فنی' ],
            'hidro' => [ 'no'=> 0 , 'name'=>'هیدرو' ],
            'lowpressure' => [ 'no'=> 0 , 'name'=>'کم فشار' ],
            'NewLicense' => [ 'no'=> 0 , 'name'=>'صدور پروانه کسب' ],
            'AddressChange' => [ 'no'=> 0 , 'name'=>'تغییر نشانی' ],
            'RasteChange' => [ 'no'=> 0 , 'name'=>'تغییر رسته' ],
            'Revival' => [ 'no'=> 0 , 'name'=>'تمدید پروانه کسب' ],
            ];
        while(! feof($file)) {
          $line = fgets($file);
          
            $record = explode(',',$line);
            $sodur_date = explode('/', $record[8]);
          
            
            if(count($sodur_date) == 3 ){
                $sodur_year = str_replace('"','',$sodur_date[0]);
                if($sodur_year == "$year"){
                    
                    $raste = str_replace('"','',$record[12]);
                    
                    $checkmarakaz = strpos($raste,"خدمات فنی");
                    if($checkmarakaz>0){
                        $number_of['agancy']['no']++;
                    }
                    
                    $checkhidro = strpos($raste,"هیدرو");
                    if($checkhidro>0){
                        $number_of['hidro']['no']++;
                    }
                    
                    $checklowpressure = strpos($raste,"کم فشار");
                    if($checklowpressure>0){
                        $number_of['lowpressure']['no']++;
                    }
                    
                    $requestType = str_replace('"','',$record[10]);
                    
                    $checkNewLic = strcmp($requestType,"صدور پروانه کسب");
                    if($checkNewLic == 0){
                        $number_of['NewLicense']['no']++;
                    }
                    
                    $checkAddressChange = strcmp($requestType,"تغییر نشانی");
                    if($checkAddressChange == 0){
                        $number_of['AddressChange']['no']++;
                    }
                    
                    $checkRasteChange = strcmp($requestType,"تغییر رسته");
                    if($checkRasteChange == 0){
                        $number_of['RasteChange']['no']++;
                    }
                    
                    $checkRevival = strcmp($requestType,"تمدید پروانه کسب");
                    if($checkRevival == 0){
                        $number_of['Revival']['no']++;
                    }
                }
            }
            
        }
        
        return view('admin.licensereport')->with(['numberOf' => $number_of]);
        */
    }
    
}
