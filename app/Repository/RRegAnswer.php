<?php

namespace App\Repository;

use App\CustomClasses\Logs;
use App\Models\IssuesModel;
use Exception;
use Illuminate\Support\Facades\Auth;

class RRegAnswer
{
    protected $model;

    public function __construct()
    {
        $this->model = new IssuesModel();
    }


    public function SetJunk($request)
    {
        $Date = Verta();
        $id = $request->id;
        $issue = $this->model->where('id', $request->id)->first();

        if($issue->trackinglater == 'yes')
        {
            $issue->trackinglater = 'y2n';
            Logs::create('update', 'issues', $id, 'status,trackinglater,answer,junk', "Status: 4 - Trackinglater: y2n - Answer: $request->answer Junk: yes");
        }else
        {
            Logs::create('update', 'issues', $id, 'status,answer,junk', "Status: 4 - Answer: $request->answer Junk: yes");
        }
        try{
            $issue->status = 4;
            $issue->junk = 'yes';
            $issue->answer =  $request->answer;
            $issue->updated_at = $Date;
            $issue->save();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function RegisterAnswer($request)
    {
        $issue = $this->model->where('id', $request->id)->first();
        $trackinglater = $this->ReturnTrackingValue($request);
        try{
            $issue->status = 1;
            $issue->answer = $request->answer;
            $issue->who_answered = Auth::id();
            $issue->trackinglater = $trackinglater;
            $issue->updated_at = Verta();
            $issue->save();
            Logs::create('update', 'issues', $request->id, 'cellphone,answer,trackinglater', "Answer: $request->answer - Trackinglater: $trackinglater");
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        return null;
    }

    private function ReturnTrackingValue($request)
    {
        $trackinglater = $request->track;
        if(isset($trackinglater)):
            $trackinglater = "yes";
        else:
            $issue = IssuesModel::where('id',$request->id)->first();
            if($issue->trackinglater == 'yes')
                $trackinglater = 'y2n';
            else
                $trackinglater = "no";
        endif;
        return $trackinglater;
    }
}