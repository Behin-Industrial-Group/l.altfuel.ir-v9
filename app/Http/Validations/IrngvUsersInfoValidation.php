<?php

namespace App\Http\Validations;

use App\Models\IrngvUsersInfo;
use App\Traits\ResponseTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class IrngvUsersInfoValidation
{
    use ResponseTrait;
    public function store($r)
    {
        $irngv_user_info = new IrngvUsersInfo();

        if(!$r->certificate_number){
            return $this->jsonResponse("certificate_number یا شماره گواهی سلامت ارسال نشده است", 400);
        }

        if(!$r->issued_date){
            return $this->jsonResponse("issued_date یا تاریخ صدور گواهی ارسال نشده است", 400);
        }

        if(!$r->owner_national_id){
            return $this->jsonResponse("owner_national_id یا کدملی مالک ارسال نشده است", 400);
        }

        if(!$r->owner_fullname){
            return $this->jsonResponse("owner_fullname یا نام و نام خانوادگی مالک ارسال نشده است", 400);
        }

        if(!$r->owner_mobile){
            return $this->jsonResponse("owner_mobile یا موبایل مالک ارسال نشده است", 400);
        }

        if(!$r->customer_fullname){
            return $this->jsonResponse("customer_fullname یا نام و نام خانوادگی متقاضی ارسال نشده است", 400);
        }

        if(!$r->customer_mobile){
            return $this->jsonResponse("customer_mobile یا موبایل متقاضی ارسال نشده است", 400);
        }

        if(!$r->car_name){
            return $this->jsonResponse("car_name یا نام خودرو ارسال نشده است", 400);
        }

        if(!$r->chassis){
            return $this->jsonResponse("chassis یا شاسی ارسال نشده است", 400);
        }

        if(!$r->plaque){
            return $this->jsonResponse("plaque یا پلاک خودرو ارسال نشده است", 400);
        }

        if(!$r->agency_code){
            return $this->jsonResponse("agency_code یا کد مرکز ارسال نشده است", 400);
        }

        if(!$r->agency_name){
            return $this->jsonResponse("agency_name یا نام مرکز ارسال نشده است", 400);
        }

        if($irngv_user_info->where('certificate_number', $r->certificate_number)->first())
            return $this->jsonResponse("برای این شماره گواهی قبلا پیامک ارسال شده است.", 300, [],20);

        if(!in_array($r->reg_type, config('irngv.valid_reg_type'))){
            return $this->jsonResponse("مقدار reg_type معتبر نیست", 400);
        }


    }
}
