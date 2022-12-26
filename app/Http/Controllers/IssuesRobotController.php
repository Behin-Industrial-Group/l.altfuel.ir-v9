<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\IssuesRobotCases as Cases;
use App\Repository\RIssuesRobot;

class IssuesRobotController extends Controller
{
    protected $RIR;
    
    public function __construct(){
        $this->RIR = new RIssuesRobot();
    }
    
    public function getRequest(Request $request){
        $case = $this->RIR->returnCase($request);
        $parentIds = $this->RIR->returnParentIds($case);
        $catagory = $this->RIR->returnCatagories($request);
        
        return view('issue_robot')->with([
            'case' => $case,
            'catagories' => $catagory,
            'parentIds' => $parentIds,
            ]);
    }

    public function AddCatagoryForm()
    {
        return view('admin.robot.add-catagory');
    }

    public function Store(Request $request)
    {
        return $this->RIR->Set($request);
    }

    public function EditAnswerForm()
    {
        return view('admin.robot.edit');
    }

    public function EditAnswer(Request $request)
    {
        return $this->RIR->Edit($request);
    }

    public function GetCatagory()
    {
        return $this->RIR->GetCatagory();
    }

    public function GetAnswer($value)
    {
        return $this->RIR->GetAnswer($value);
    }

    public function RecieveAnswer($id)
    {
        return $this->RIR->IncrementCount($id);
    }
}