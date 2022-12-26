<?php

namespace App\Repository;
use App\Models\IssuesRobotCasesModel as Cases;
use stdClass;

class RIssuesRobot
{
    protected $model;

    public function __construct()
    {
        $this->model = new Cases();
    }
    
    public function returnCase($request){
        if(is_null($request->id)){
            $case = Cases::find(1);
        }
        else{
            $case = Cases::find($request->id);
        }
        
        return $case;
    }
    
    public function returnCatagories($request){
        if(is_null($request->id)){
            $catagories = Cases::where('parent_id', 1)->where('id', '!=', 1)->get();
        }
        else{
            $catagories = Cases::where('parent_id', $request->id)->where('id', '!=', $request->id)->get();
        }
        return $catagories;
    }
    
    public function returnParentIds($case){
        $i = new stdClass();
        $i->id = 1;
        if(!is_null($case)){
            for($n=1;$n<=$case->parent_id;$n++){
                $i->id = $n++;
            }
        }
        
        return $i;
    }

    public function Set($request)
    {
        try{
            $case = $this->model;
            $case->name = $request->name;
            $case->value = $request->value;
            $case->parent_id = $request->parent_id;
            $case->save();
            return 'done';
        }
        catch(Exception $e){
            return $e->getMessaeg();
        }
    }

    public function Edit($request)
    {
        try{
            $case = $this->model->find($request->value);
            $case->answer = $request->answer;
            $case->save();
            return 'done';
        }
        catch(Exception $e){
            return $e;
        }
    }

    public function GetCatagory()
    {
        $numbers = $this->model->get();
        $options = "";
        foreach($numbers as $num){
            $options .= "<option value='$num->id'>$num->name</option>";
        }
        return $options;
    }

    public function GetAnswer($value)
    {
        return $this->model->find($value)->answer;
    }

    public function IncrementCount($id)
    {
        return $this->model->find($id)->increment('count');
    }
}