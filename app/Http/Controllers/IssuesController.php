<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\IssuesModel;
use App\Models\IssuesCatagoryModel;
use App\Models\MarakezModel;
use App\Models\RelatedIssueModel;
use Illuminate\Support\Facades\DB;
use File;
use Verta;
use App\Traits\reCAPTCHA;
use App\CustomClasses\IssuesCatagory;
use App\CustomClasses\Logs;
use App\CustomClasses\Access;
use App\CustomClasses\Marakez;
use App\Enums\EnumsEntity;
use App\Models\HidroModel;
use App\Repository\RIssue;
use App\Repository\RRegAnswer;
use Exception;
use SoapClient;


define("BASEURL","https://new.payamsms.com/services/v2/?wsdl");
define("APIKEY","VsQ4_aP39E_oeH4HfXZrHA");
define("PASS","irngv123");
define("FROM",20003807);


class IssuesController extends Controller
{
    use reCAPTCHA;
    protected $RRegAnswer;
    protected $RIssue;
    protected $MVController;
    protected $enums;

    public function __construct()
    {
        $this->RRegAnswer = new RRegAnswer();
        $this->RIssue = new RIssue();
        $this->MVController = new MobileVerificationController();
        $this->enums = new EnumsEntity();
    }

    private function showIssueRegisterForm( $catagories, $message = null, $error = null )
    {
        return view('issue')->with(['catagories' => $catagories, 'message' => $message, 'error' => $error]);
    }

    private function showIssueSuccess($message=null, $error=null)
    {
        return view('issue')->with(['message' => $message, 'error' => $error]);
    }

    public function selectIssuesCatagoryForm($message = null, $error = null)
    {
        return view('selectIssuesCatagoryForm');
    }

    public function issuesCatagoryForm($catagory)
    {
        $catagories = IssuesCatagoryModel::where( 'catagory', $catagory )->get();

        return $this->showIssueRegisterForm($catagories);

    }

    public function Register(Request $request)
    {
        $issue = new IssuesModel($request->all());
        $file = $request->file('issue_file');

        $result = $this->checkRecaptcha($request->input('g-recaptcha-response'));
        
        if($result == false)
        {
            //return 'گزینه من ربات نیستم را بررسی کنید';
        }
        
        // $check_code_url = str_replace('http://', 'https://', url('mv/check-code/' . $request->cellphone. '/' . $request->mv_code));
        // $code_result = file_get_contents($check_code_url);
        // if($code_result === 'err')
        //     return 'کدنامعتبر است';

        if($this->RIssue->nid_is_markaz($request->NationalID)){
            $c = $this->RIssue->cellphone_is_not_for_markaz_nid($request->NationalID, $request->cellphone);
            if($c)
                return $c;
        }

        if(!$request->issue){
            return "متن پیام نباید خالی باشد";
        }

        if(!$request->name){
            return "نام و نام خانوادگی نباید خالی باشد";
        }

        if(!$request->NationalID){
            return "کدملی نباید خالی باشد";
        }

        if(!$request->cellphone){
            return "شماره موبایل نباید خالی باشد";
        }
         
        if(empty($file))
        {
            $Date = Verta();
            $issue->created_at = $Date;
            $issue->updated_at = $Date;
            if($issue->save())
            {
                Logs::create('create', 'issues',
                $issue->id,
                'name,catagory,NationalID,cellphone,issue,status',
                "name: $request->name - catagory: $request->catagory - NationalID: $request->NationalID - cellphone: $request->cellphone - issue: $request->issue - status: $issue->status");

                return 'ok';
            }
        }

        if($file->getSize() > $this->enums->max_upload_file_size())
            return 'حجم فایل بیش از '. $this->enums->max_upload_file_size() .' کیلو بایت است';
        


        $file_type = strtolower($file->getClientOriginalExtension());

        if($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg')
        {
            $path = 'public/uploads/' . $request->input('cellphone') ;
            $filename = rand(10000,99999). "." . strtolower($file->getClientOriginalExtension());

            $issue->file =  $path .'/'. $filename ;
            $Date = Verta();
            $issue->created_at = $Date;
            $issue->updated_at = $Date;

            if(file_exists($path))
            {

            }else{
                File::makeDirectory( $path,0777,true );
            }
            $file->move( $path, $filename );

            if($issue->save())
            {
                Logs::create('create', 'issues',
                $issue->id,
                'name,catagory,NationalID,cellphone,issue,file,status',
                "name: $request->name - catagory: $request->catagory - NationalID: $request->NationalID - cellphone: $request->cellphone - issue: $request->issue - file: $issue->file - status: $issue->status");

                return 'ok';
            }else{
                return 'ناموفق. مجدد تلاش کنید';
            }
        }else{
            return 'فرمت فایل باید jpg, png, jpeg باشد';
        }
    }

    public function answerform(Request $request)
    {
        return view('answerform');
    }

    public function showanswer(Request $request)
    {
        $answers = IssuesModel::where('NationalID', $request->NationalID)->where('cellphone', $request->cellphone)->get();

        return view('showanswer', [ 'answers' => $answers ]);

    }

    //SHOW LIST OF ISSUES IN CERTAIN CATAGORY
    public function issues_show($catagory,$tracking = null)
    {
        $t = "Issues_".$catagory."_show";
        $access = Access::check($t);
        return view('admin.issues', [ 'catagory' => $catagory, 'tracking_later' => $tracking]);
    }

    public function GetIssues($catagory,$tracking=null)
    {
        return json_encode($this->RIssue->GetIssues($catagory,$tracking));
    }


    //SHOW A CERTAIN ISSUE
    public function issue_show($catagory, $NationalID, $cellphone = null, $message = null)
    {
        $access = Access::check('Issues_issue_show');

        $issues = IssuesModel::where('NationalID', $NationalID)->orderBy('id')->get();
        $i=0;
        foreach($issues as $issue){
            $issues[$i]->related = DB::table('related_issue as ri')
                                        ->join('issues as i', 'i.id', 'ri.related_issue_id')
                                        ->where('ri.issue_id', $issue->id)
                                        ->get();
            $i++;
        }
        $Date = Verta();

        if(isset($issues[0]['name']))
            $name = $issues[0]['name'];
        else
            $name = '';

        if(isset($issues[0]['cellphone']))
            $cellphone = $issues[0]['cellphone'];

        $isAgancy = Marakez::isAgancy($NationalID);
        if($isAgancy){
            $isAgancy = 'fa fa-check-circle';
        }else{
            $isAgancy = '';
        }


        $user = array(
            'name' => $name,
            'NationalID' => $NationalID,
            'cellphone' => $cellphone,
            'isAgancy' => $isAgancy,
            );

        $catagories  = IssuesCatagoryModel::where('catagory', '!=', '')->get();

        return view('admin.showissue')->with([
            'issues' => $issues,
            'catagory' => $catagory,
            'user' => $user,
            'catagories' => $catagories
            ]);
    }

    // REGISTER THE ANSWER
    public function RegisterAnswer(Request $request){
        $access = Access::check('Issues_Reganswer');
        //SET JUNK ISSUE
        $junk = $request->junk;
        if(isset($junk)):
            return $this->RRegAnswer->SetJunk($request);
        endif;
        $reg_answer = $this->RRegAnswer->RegisterAnswer($request);

        if(!is_null($reg_answer)){
            return $reg_answer;
        }
        return 'done';
    }

    public function search(Request $request,$catagory,$field,$q){
        $access = Access::check('Issues_search');

        if($catagory == 'all')
            $issues = IssuesModel::where("$field",'like', "%$q%")->orderBy('status')->orderBy('id','desc')->get();
        else
            $issues = IssuesModel::where('catagory', "$catagory")->where("$field",'like', "%$q%")->orderBy('id','desc')->get();

        return view('admin.issues', [ 'Issues' => $issues, 'catagory'=> "$catagory" ]);
    }

    public function catagories_form()
    {
        $catagories = IssuesCatagoryModel::get();

        return view('admin.issuesCatagory')->with(['catagories' => $catagories]);
    }

    public function create_issue_form()
    {
        Access::check('Issues_create_issue_form');

        return view('admin.createIssue');
    }

    public function create_issue(Request $request)
    {
        Access::check('Issues_create_issue');

        return $this->issue_show($request->catagory,$request->NationalID, $request->cellphone);
    }

    public function register_issue(Request $request)
    {
        Access::check('Issues_register_issue');
        $success = $this->RIssue->CreateNewIssue($request);
        if($success){
            return redirect()->back();
        }
        return $success;

    }

    public function send_sms($text,$cellphone)
    {
        /*
        $h = str_split($cellphone);
        $m = '98';
        for($i=1;$i<11;$i++){
        	$m = $m . $h[$i];
        }
        $m = (int) $m;

        libxml_disable_entity_loader(false);
        $client = new SoapClient(BASEURL.'/wsdl?t='.time(), array(
            'location' => BASEURL.'/soap',
            'use'      => SOAP_LITERAL,
            'style'    => SOAP_DOCUMENT,
            'trace'    => 1
        ));
        */
        //Send Message
        /*
        $response = $client->send(array(
            'userName'    => APIKEY,
            'password'    => PASS,
            'sourceNo'    => FROM,
            'destNo'      => array($m),
            'sourcePort'  => 0,
            'destPort'    => 0,
            'clientId'    => null,
            'messageType' => null,
            'encoding'    => null,
            'longSupported' => false,
            'dueTime'     => null,
            'content'     => $text
        ));
        */
        /*
        $messageIds = [];
        if ($response->sendReturn->status == 0) {
          $messageIds = $response->sendReturn->id->id;
        }
        */
        return true;
    }

    public function sendto(Request $r)
    {
        Access::check( 'Issues_sendto' );
        return $this->RIssue->SetNewCatagory($r);
    }

    public function junkDuplicate()
    {
        $ar =  IssuesModel::groupby('issue')->havingRaw('COUNT(issue) > 1')->get();
        $m=0;
        foreach($ar as $a){
            $dup = IssuesModel::where( 'issue', $a->issue )->where( 'NationalID', $a->NationalID )->get();
            $i=1;
            foreach( $dup as $row ){
                if( $i!=1 ){
                    if( $row->status == 0 ){
                        IssuesModel::where( 'id', $row->id )->update( [
                            'answer' => 'تکراری' ,
                            'status' => 4,
                            'junk' => 'yes',
                            'updated_at' => Verta()
                            ] );
                        echo $row->id ," - ", $row->NationalID , " - " , $row->issue , " - Delete<br>";
                        $m++;
                    }
                }
                $i++;
            }
        }
        return "$m مورد تکراری شناسایی و عدم نیاز به پاسخ ثبت شد";
    }

    public function GetIssuesNumberDatalist($no)
    {
        return $this->RIssue->GetIssueNo($no);
    }

    public function SetRelatedIssue(Request $request, $issue_id)
    {
        Access::check('Issues_SetRelatedIssue');
        return $this->RIssue->SetRelatedIssue($request, $issue_id);
    }

    public function SetSurvay($id)
    {
        return $this->RIssue->SetSurvay($id);
    }

    public function add_catagory(Request $r)
    {
        $this->RIssue->add_catagory($r);
        return 'انجام شد';
    }
}
