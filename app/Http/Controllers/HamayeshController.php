<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HidroModel;
use App\Models\MarakezModel;
use App\Models\ProvinceModel;
use App\Models\Workshop;
use App\Models\WorkshopClasses;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsRedirected;

use function PHPUnit\Framework\returnSelf;

class HamayeshController extends Controller
{
    
    public function register_workshop_form()
    {
        return view('hamayesh.register_workshop')->with([
            'provinces' => ProvinceModel::get(),
            'classes' => WorkshopClasses::where('enable',1)->get()
        ]);
    }

    public function register_workshop(Request $r)
    {
        try{
        $v = $this->register_workshop_validation($r);
        if($v)
            return $v;
        $w = Workshop::create($r->all());
        $fill = Workshop::where('workshop_name', $r->workshop_name)->count();
        $capacity = WorkshopClasses::find($r->workshop_name)->capacity;
        if($fill >= $capacity){
            return response('ظرفیت کلاس تکمیل شده است، شما در لیست رزرو قرار گرفته اید در صورت افزایش ظرفیت، اطلاع رسانی می شود.');
        }
        return response('ثبت نام انجام شد');
        }
        catch(Exception $e){
             return response($e->getMessage());
        }
    }

    public function register_workshop_validation($r)
    {  
        return response('مهلت ثبت نام به پایان رسیده');
        if(!$r->name)
            return response('نام و نام خانوادگی را تکمیل کنید');
        
        if(!$r->national_id)
            return response('کدملی را وارد کنید');

        if(strlen($r->national_id) != 10)
            return response('طول کدملی باید 10 رقم باشد');

        if(!$r->mobile)
            return response('موبایل را وارد کنید');

        if(strlen($r->mobile) != 11)
            return response('تعداد ارقام شماره موبایل باید 11 رقم باشد');

        if($r->type == 'agency'){
            $m = MarakezModel::where('CodeEtehadie', $r->type_des)->where('Province', $r->province)->first();
            if(!$m){
                return response('کدمرکز با استان همخوانی ندارد.');
            }
        }
        if($r->type == 'hidro'){
            $m = HidroModel::where('CodeEtehadie', $r->type_des)->where('Province', $r->province)->first();
            if(!$m){
                return response('کد آزمایشگاه با استان همخوانی ندارد.');
            }
        }

        if( Workshop::where('national_id', $r->national_id)->where('workshop_name', $r->workshop_name)->first() ){
            return response('شما قبلا در این کلاس ثبت نام کرده اید');
        } 
        
    }

    public function add_class_form()
    {
        return view('admin.hamayesh.add-class')->with([
            'classes' => WorkshopClasses::get(),
        ]);
    }

    public function add_class(Request $r)
    {
        $w = WorkshopClasses::create($r->all());
        return response('کلاس جدید اضافه شد ');
    }

    public function list()
    {
        return view('admin.hamayesh.list')->with([
            'rows'=> Workshop::groupBy('workshop_name', 'national_id')->get(),
        ]);
    }

    public function get_edit_class_data($id)
    {
        return WorkshopClasses::find($id);
    }

    public function edit_class(Request $r)
    {
        $w = WorkshopClasses::find($r->id)->update($r->all());
        return response('ویرایش شد');
    }
}
