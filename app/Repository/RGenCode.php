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

class RGenCode
{
    private $province;
    private $marakez;
    private $hidro;
    private $provinceModel;

    public function __construct($province) {
        $this->province = $province;
        $this->marakez = new MarakezModel();
        $this->hidro = new HidroModel();
        $this->kamfeshar = new KamFesharModel();
        $this->provinceModel = new ProvinceController();
    }


    public function Markaz()
    {
        return $this->GetLastMarkazCode() +1 ;
    }

    private function GetLastMarkazCode()
    {
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
        $province_code = $this->provinceModel->GetCode($this->province);

        $new_code = "H" . $province_code . $year . $no;

        return $new_code;
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
        $province_code = $this->provinceModel->GetCode($this->province);

        $new_code = "K" . $province_code . $year . $no;

        return $new_code;
    }

    private function GetLastHidroCode()
    {
        $all = $this->hidro->where('province', $this->province)->whereNotNull('CodeEtehadie')->get();
        foreach($all as $a){
            $no = $a->CodeEtehadie[5] . $a->CodeEtehadie[6];
            $b[] =  (int) $no;
        }

        if(!empty($b)){
            $b = Arr::sort($b);
            return Arr::last($b);
        }else{
            return null;
        }
    }

    private function GetLastKamfesharCode()
    {
        $all = $this->kamfeshar->where('province', $this->province)->whereNotNull('CodeEtehadie')->get();
        foreach($all as $a){
            $no = $a->CodeEtehadie[5] . $a->CodeEtehadie[6];
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
