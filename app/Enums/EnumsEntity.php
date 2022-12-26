<?php

namespace App\Enums;

use App\Models\Option;

class EnumsEntity
{
    public $options;

    public function __construct() {
        $this->options = new Option();
    }
    public static $IssueStatusType = [
        0 => 'جدید',
        1 => 'پاسخ داده شده',
        2 => '',
        3 => '',
        4 => 'عدم نیاز به پاسخ',
    ];
    public static $AsignType = [
        [ 'key' => 0 , 'value' => 'جدید' ],
        [ 'key' => 1 , 'value' => 'تخصیص داده شد' ],
        [ 'key' => 2 , 'value' => 'درخواست رد شد' ],
        [ 'key' => 3 , 'value' => 'غیرفعال شد' ],
    ];

    public static $RequestType = [
        'asign' => 'تخصیص',
        'remove' => 'حذف',
    ];

    public static $AgencyType = [
        'agency' => [
            'name' => 'agency',
            'fa_name' => 'مرکز خدمات فنی',
            'value' => 'agency'
        ],
        'kamfeshar' => [
            'name' => 'kamfeshar',
            'fa_name' => 'مرکز کم فشار',
            'value' => 'kamfeshar'
        ],
        'hidro' => [
            'name' => 'hidro',
            'fa_name' => 'آزمایشگاه تست هیدرو استاتیک',
            'value' => 'hidro'
        ]
    ];
    
    public function max_upload_file_size(){
        return $this->options->where('key', 'max_upload_file_size')->first()->value;
    }

    const _3month_sms_template = 'یادآوری
کمتر از سه ماه تا پایان تاریخ انقضا پروانه کسب شما باقی مانده است.لطفا هر چه سریعتر نسبت به تمدید پروانه کسب اقدام نمایید. 
ثبت درخواست تمدید از سامانه: 
https://iranianasnaf.ir
اتحادیه کشوری سوخت های جایگزین';


}
