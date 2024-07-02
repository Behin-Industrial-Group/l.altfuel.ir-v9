<?php

namespace App\Enums;

use App\Models\Option;

class EnumsEntity
{
    public $options;

    public function __construct()
    {
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
        ['key' => 0, 'value' => 'جدید'],
        ['key' => 1, 'value' => 'تخصیص داده شد'],
        ['key' => 2, 'value' => 'درخواست رد شد'],
        ['key' => 3, 'value' => 'غیرفعال شد'],
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

    public function max_upload_file_size()
    {
        return $this->options->where('key', 'max_upload_file_size')->first()->value;
    }

    const irngv_api_msg_code = [
        0 => "موفقیت آمیز بود",
        1 => "ip خالی است",
        2 => 'ip شما مورد تایید نیست',
        3 => 'توکن را نیز ارسال کنید',
        4 => 'توکن ارسالی مورد تایید نیست',
        5 => "توکن منقضی شده است",
        6 => "ip یافت نشد",
        7 => "نام کاربری یا رمز عبور صحیح نیست",
        8 => "certificate_number یا شماره گواهی سلامت ارسال نشده است",
        9 => "issued_date یا تاریخ صدور گواهی ارسال نشده است",
        10 => "owner_national_id یا کدملی مالک ارسال نشده است",
        11 => "owner_fullname یا نام و نام خانوادگی مالک ارسال نشده است",
        12 => "owner_mobile یا موبایل مالک ارسال نشده است",
        13 => "customer_fullname یا نام و نام خانوادگی متقاضی ارسال نشده است",
        14 => "customer_mobile یا موبایل متقاضی ارسال نشده است",
        15 => "car_name یا نام خودرو ارسال نشده است",
        16 => "chassis یا شاسی ارسال نشده است",
        17 => "plaque یا پلاک خودرو ارسال نشده است",
        18 => "agency_code یا کد مرکز ارسال نشده است",
        19 => "agency_name یا نام مرکز ارسال نشده است",
        20 => "برای این شماره گواهی قبلا پیامک ارسال شده است.",

    ];

    const irngv_poll_question = [
        'q1' => [
            'enable' => 1,
            'question' => "1- میزان رضایت شما از کیفیت و سطح خدمات ارایه شده در مرکز چقدر است؟",
            'answers' => [
                5 => "خیلی زیاد",
                4 => "زیاد",
                3 => "متوسط",
                2 => "کم",
                1 => "خیلی کم",
            ],
            'reg_type' => 1
        ],
        'q2' => [
            'enable' => 1,
            'question' => "2- میزان رضایت شما از هزینه خدمات چقدر است؟",
            'answers' => [
                5 => "خیلی زیاد",
                4 => "زیاد",
                3 => "متوسط",
                2 => "کم",
                1 => "خیلی کم",
            ],
            'reg_type' => 2
        ],
        'q3' => [
            'enable' => 1,
            'question' => "3- میزان رضایت شما از رفتار پرسنل مرکز خدمات چقدر است؟",
            'answers' => [
                5 => "خیلی زیاد",
                4 => "زیاد",
                3 => "متوسط",
                2 => "کم",
                1 => "خیلی کم",
            ],
            'reg_type' => 2
        ],
        'q4' => [
            'enable' => 1,
            'question' => "4- از مدت زمان انجام خدمات چقدر رضایت دارید؟",
            'answers' => [
                5 => "خیلی زیاد",
                4 => "زیاد",
                3 => "متوسط",
                2 => "کم",
                1 => "خیلی کم",
            ],
            'reg_type' => 2
        ],
        'q5' => [
            'enable' => 1,
            'question' => "5- آیا به شما فاکتور ارائه شد؟",
            'answers' => [
                1 => "بله",
                2 => "خیر",
            ],
            'reg_type' => 1
        ],
    ];

    const _3month_sms_template = 'یادآوری
کمتر از سه ماه تا پایان تاریخ انقضا پروانه کسب شما باقی مانده است.لطفا هر چه سریعتر نسبت به تمدید پروانه کسب اقدام نمایید.
ثبت درخواست تمدید از سامانه:
https://iranianasnaf.ir
اتحادیه کشوری سوخت های جایگزین';
}
