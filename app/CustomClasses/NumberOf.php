<?php 

namespace App\CustomClasses;
use App\Models\IssuesModel;

class NumberOf
{
    public static function Ticket($catagory)
    {
        if($catagory == 'irngvagancy')
        {
            $no = IssuesModel::join('marakez1', 'marakez1.NationalID', 'issues.NationalID')->where('issues.catagory', 'irngv')->where('status', 0)->count();
        }else
        {
            $no = IssuesModel::where('catagory', $catagory)->where('status', 0)->count();
        }
        
        return $no;
    }
}