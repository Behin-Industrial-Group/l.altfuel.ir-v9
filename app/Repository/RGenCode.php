<?php

namespace App\Repository;

use App\CustomClasses\Marakez;
use App\Http\Controllers\ProvinceController;
use App\Models\HidroModel;
use App\Models\MarakezModel;
use App\Models\KamFesharModel;
use App\Models\ProvinceModel;
use Facades\Verta;
use Illuminate\Support\Arr;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\Cities\Controllers\CityController;

class RGenCode
{
    private $province;
    private $province_ids;
    private $parent_ids;
    private $agency_codes;
    private $marakez;
    private $hidro;
    private $kamfeshar;
    private $provinceModel;
    private $province_name;
    private $province_code;

    public function __construct($province, $customer_type) {
        $this->province = $province;
        $this->province_name = CityController::getById($this->province)->province;
        $this->province_code = ProvinceController::GetCode($this->province_name);
        

        $this->marakez = new MarakezModel();
        $this->hidro = new HidroModel();
        $this->kamfeshar = new KamFesharModel();
        // $this->provinceModel = new ProvinceController();
    }


    public function Markaz()
    {
        return $this->GetLastMarkazCode() +1 ;
    }

    private function GetLastMarkazCode()
    {
        $this->agency_codes = AgencyInfo::where('key','agency_code')->where('value','like', "$this->province_code%")->pluck('value');
        return Arr::last(array_map('intval', $this->agency_codes->toArray()));
        return (int) $this->marakez->where('province', $this->province)->orderBy('CodeEtehadie', 'desc')->first()->CodeEtehadie;
    }

    public function Hidro()
    {
        $last_code = $this->GetLastHidroCode();
        if($last_code !== null){
            $no = $last_code +1;
            $no = $this->Length($no);
        }else{
            $no = "01";
        }

        $date = (string)Verta();
        $year = explode("-", explode(" ", $date)[0])[0][2] . explode("-", explode(" ", $date)[0])[0][3];

        $new_code = "H" . $this->province_code . $year . $no;

        return $new_code;
    }

    

    private function GetLastHidroCode()
    {
        // $all = $this->hidro->where('province', $this->province)->whereNotNull('CodeEtehadie')->get();
        $this->agency_codes = AgencyInfo::where('key','agency_code')->where('value','like', "H$this->province_code%")->pluck('value');
        $all = Arr::sort($this->agency_codes);
        foreach($all as $a){
            $no = $a[5];
            if(isset( $a[6])){
                $no .=  $a[6];
            }
            $b[] =  (int) $no;
        }

        if(!empty($b)){
            $b = Arr::sort($b);
            return Arr::last($b);
        }else{
            return null;
        }
    }

    private function GetProvinceCode()
    {
        // $all = $this->hidro->where('province', $this->province)->whereNotNull('CodeEtehadie')->get();
        $all = Arr::sort($this->agency_codes);
        foreach($all as $a){
            $no = $a[1] . $a[2];
            $b[] =  (int) $no;
        }

        if(!empty($b)){
            $b = Arr::sort($b);
            return Arr::last($b);
        }else{
            return null;
        }
    }
    public function Kamfeshar()
    {
        $last_code = $this->GetLastKamfesharCode();
        if($last_code !== null){
            $no = $last_code +1;
            $no = $this->Length($no);
        }else{
            $no = "01";
        }

        $date = (string)Verta();
        $year = explode("-", explode(" ", $date)[0])[0][2] . explode("-", explode(" ", $date)[0])[0][3];
        $province_code = $this->GetProvinceCode();

        $new_code = "K" . $province_code . $year . $no;

        return $new_code;
    }

    private function GetLastKamfesharCode()
    {
        $this->agency_codes = AgencyInfo::where('key','agency_code')->where('value','like', "K$this->province_code%")->pluck('value');
        $all = Arr::sort($this->agency_codes);
        foreach($all as $a){
            $no = $a[5] ;
            if(isset( $a[6])){
                $no .=  $a[6];
            }
            $b[] =  (int) $no;
        }

        if(!empty($b)){
            $b = Arr::sort($b);
            return Arr::last($b);
        }else{
            return null;
        }
    }

    private function Length($no)
    {
        if(strlen($no) === 2)
            return $no;
        if(strlen($no) === 1)
            return "0$no";
    }
}
