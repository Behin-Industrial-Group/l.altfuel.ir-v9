<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\IssuesModel;
use App\Models\IssuesCatagoryModel;
use App\Models\MarakezModel;
use App\Models\VideosModel;
use App\Models\VideosCatagoriesModel;
use File;
use Verta;
use App\Traits\reCAPTCHA;
use App\CustomClasses\IssuesCatagory;
use App\CustomClasses\Logs;
use App\CustomClasses\Access;
use SoapClient;


class VideosController extends Controller
{
    public function showList($catagory)
    {
        Access::check( "Videos_showList$catagory" );
        $videos = VideosModel::where( 'catagory', $catagory )->get();
        
        return view( 'admin.LearningVideos.show' )->with( [ 'videos' => $videos ] );
    }
    
    public function addForm( $message = null )
    {
        $catagories = VideosCatagoriesModel::get();
        return view( 'admin.LearningVideos.add' )->with( [ 'message' => $message ,'catagories' => $catagories ] );
    }
    
    public function add(Request $r)
    {
        Access::check( "Videos_add" );
        
        $video = new VideosModel( $r->all() );
        $video->updated_at = Verta();
        $video->created_at = Verta();
        
        $video->save();
        $message = "ثبت شد";
        return $this->addForm( $message );
    }
    
    public function addCatagoryForm()
    {
        return view( 'admin.LearningVideos.addCatagory' );
    }
    
    public function addCatagory(Request $r)
    {
        Access::check( "Videos_addCatagory" );
        
        $catagory = new VideosCatagoriesModel( $r->all() );
        $catagory->updated_at = Verta();
        $catagory->created_at = Verta();
        
        $catagory->save();
        $message = "ثبت شد";
        return view( 'admin.LearningVideos.addCatagory' )->with( [ 'message' => $message ] );
    }
    
}
