<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zarinpal\Zarinpal;
use SoapClient;
use verta;
use App\MarakezModel;

class DownloadController extends Controller
{
    public function PlatereaderForm(){
        return view("platereaderdownload");
    }
    
    public function Platereader(Request $request){
        $r = MarakezModel::where('CodeEtehadie', $request->CodeEtehadie)->where('GuildNumber', $request->GuildNumber)->first();
        if($r):
            header("Location: http://l.altfuel.ir/public/uploads/platereader/PlateReader-99-03-21.zip");
        else:
            $error = "یافت نشد";
            return view("platereaderdownload")->with(['error' => $error]);
        endif;
    }
}
