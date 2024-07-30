<?php

return [
    'fin_uploads' => 'fin_uploads',
    'ins_uploads' => 'ins_uploads',
    'doc_uploads' => 'doc_uploads',
    'show_non_valid_info' => true,
    'main_field_name' => 'guild_catagory',
    'default_fields' => ['file_number', 'guild_catagory', 'firstname', 'lastname', 'national_id', 'agency_code', 'mobile', 'new_status', 'last_referral', 'province', 'city'],
    'valid_file_type' => ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'],
    'customer_type' => [
        'charging-fire-cylenders' => [
            'name' => 'charging fire cylenders',
            'catagory_fa' => 'شارژ سیلندرهای آتش نشانی',
            'fields' => [
                'file_number' => ['type' => 'text', 'required' => true],
                'last_request_date' => ['type' => 'text', 'required' => true],
                'last_request_type' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'صدور پروانه', 'label' => 'صدور پروانه'],
                        ['value' => 'تمدید پروانه کسب', 'label' => 'تمدید پروانه کسب'],
                        ['value' => 'تغییر نشانی', 'label' => 'تغییر نشانی'],
                        ['value' => 'تغییر رسته', 'label' => 'تغییر رسته'],
                        ['value' => 'تغییر مالکیت', 'label' => 'تغییر مالکیت'],
                    ]
                ],
                'guild_catagory' => ['type' => 'text', 'disabled' => true, 'default' => 'شارژ سیلندرهای آتش نشانی', 'required' => false],
                'guild_catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'charging-fire-cylenders', 'label' => 'شارژ سیلندرهای آتش نشانی'],
                        ['value' => 'retail', 'label' => 'خرده فروشی'],
                        ['value' => 'sale-and-charging-insdustrial-gas', 'label' => 'فروش و شارژ گازهای صنعتی'],
                        ['value' => 'saling-fire-cylenders', 'label' => 'فروش سیلندرهای آتش نشانی'],
                        ['value' => 'wholesaling-industrial-gas', 'label' => 'عمده فروشی گازهای صنعتی'],
                        ['value' => 'producer', 'label' => 'تولیدکننده'],
                        ['value' => 'unknown', 'label' => 'بدون رسته'],

                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ], 'catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'industrial', 'label' => 'صنعتی'],
                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_or_legal_name' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'status' => ['type' => 'text', 'default' => '', 'disabled' => true],
                'new_status' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'جدید', 'label' => 'جدید'],
                        ['value' => 'درحال بررسی', 'label' => 'در حال بررسی'],
                        ['value' => 'در حال تکمیل', 'label' => 'در حال تکمیل'],
                        ['value' => 'صادر شده', 'label' => 'صادر شده'],
                    ]
                ],
                'reviewer' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                    ]
                ],
                'last_referral' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                        ['value' => 'مهموم', 'label' => 'مهموم'],
                        ['value' => 'کیا', 'label' => 'کیا'],
                        ['value' => 'مرادی', 'label' => 'مرادی'],
                        ['value' => 'یگانگی', 'label' => 'یگانگی'],
                        ['value' => 'بایگانی', 'label' => 'بایگانی'],
                    ]
                ],
                'description' => ['type' => 'textarea', 'default' => '', 'required' => false],

            ],
            'memberships' => [
                '96' => ['membership96', 'membership96_pay_date', 'membership96_ref_id', 'membership96_pay_file'],
                'donate96' => ['donate96', 'donate96_pay_date', 'donate96_ref_id', 'donate96_pay_file'],
                'sodur96' => ['sodur96', 'sodur96_pay_date', 'sodur96_ref_id', 'sodur96_pay_file'],

                '97' => ['membership97', 'membership97_pay_date', 'membership97_ref_id', 'membership97_pay_file'],
                'donate97' => ['donate97', 'donate97_pay_date', 'donate97_ref_id', 'donate97_pay_file'],
                'sodur97' => ['sodur97', 'sodur97_pay_date', 'sodur97_ref_id', 'sodur97_pay_file'],

                '98' => ['membership98', 'membership98_pay_date', 'membership98_ref_id', 'membership98_pay_file'],
                'donate98' => ['donate98', 'donate98_pay_date', 'donate98_ref_id', 'donate98_pay_file'],
                'sodur98' => ['sodur98', 'sodur98_pay_date', 'sodur98_ref_id', 'sodur98_pay_file'],

                '99' => ['membership99', 'membership99_pay_date', 'membership99_ref_id', 'membership99_pay_file'],
                'donate99' => ['donate99', 'donate99_pay_date', 'donate99_ref_id', 'donate99_pay_file'],
                'sodur99' => ['sodur99', 'sodur99_pay_date', 'sodur99_ref_id', 'sodur99_pay_file'],

                '00' => ['membership00', 'membership00_pay_date', 'membership00_ref_id', 'membership00_pay_file'],
                'donate00' => ['donate00', 'donate00_pay_date', 'donate00_ref_id', 'donate00_pay_file'],
                'sodur00' => ['sodur00', 'sodur00_pay_date', 'sodur00_ref_id', 'sodur00_pay_file'],

                '01' => ['membership01', 'membership01_pay_date', 'membership01_ref_id', 'membership01_pay_file'],
                'donate01' => ['donate01', 'donate01_pay_date', 'donate01_ref_id', 'donate01_pay_file'],
                'sodur01' => ['sodur01', 'sodur01_pay_date', 'sodur01_ref_id', 'sodur01_pay_file'],

                '02' => ['membership02', 'membership02_pay_date', 'membership02_ref_id', 'membership02_pay_file'],
                'donate02' => ['donate02', 'donate02_pay_date', 'donate02_ref_id', 'donate02_pay_file'],
                'sodur02' => ['sodur02', 'sodur02_pay_date', 'sodur02_ref_id', 'sodur02_pay_file'],

                '03' => ['membership03', 'membership03_pay_date', 'membership03_ref_id', 'membership03_pay_file'],
                'donate03' => ['donate03', 'donate03_pay_date', 'donate03_ref_id', 'donate03_pay_file'],
                'sodur03' => ['sodur03', 'sodur03_pay_date', 'sodur03_ref_id', 'sodur03_pay_file'],

                'donate1' => ['donate1', 'donate1_pay_date', 'donate1_ref_id', 'donate1_pay_file'],
            ],
            'fin_fields' => [
                'fin_details' => ['type' => 'textarea'],
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],

            ],
            'debts' => [
                '1' => ['debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description'],
            ],
            'docs' => [
                'national_card',
                'birth_certificate_image',
                'personal_image',
                'education_degree',
                'military_card',
                'business_rules_certificate',
                'lease_or_ownership_doc',
                'partner_consent_letter',
                'tax',
                'nitrogen_cylinder_hidrostatic_test_certificate',
                'pressure_gauge_calibration_certificate',
                'weightbridge_calibration_certificate',
                'gas_storage_tank_certificate',
                'commitment',
                'revoke_business_license_form',
                'previous_business_license',
                'postal_code_certificate'
            ],
            'foreman' => [
                'foreman_firstname' => ['type' => 'text'],
                'foreman_lastname' => ['type' => 'text'],
                'foreman_national_id' => ['type' => 'text'],
                'foreman_mobile' => ['type' => 'text'],
                'foreman_national_card' => ['type' => 'file'],
                'foreman_birth_certificate_image' => ['type' => 'file'],
                'foreman_personal_image' => ['type' => 'file'],
            ],
            'inspection' => [
                '01' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '02' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '03' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '04' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '05' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
            ],
        ],
        'retail' => [
            'name' => 'retail',
            'catagory_fa' => 'خرده فروشی گازهای طبی و صنعتی',
            'fields' => [
                'file_number' => ['type' => 'text', 'required' => true],
                'last_request_date' => ['type' => 'text', 'required' => true],
                'last_request_type' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'صدور پروانه', 'label' => 'صدور پروانه'],
                        ['value' => 'تمدید پروانه کسب', 'label' => 'تمدید پروانه کسب'],
                        ['value' => 'تغییر نشانی', 'label' => 'تغییر نشانی'],
                        ['value' => 'تغییر رسته', 'label' => 'تغییر رسته'],
                        ['value' => 'تغییر مالکیت', 'label' => 'تغییر مالکیت'],
                    ]
                ],
                'guild_catagory' => ['type' => 'text', 'disabled' => true, 'default' => 'خرده فروشی گازهای طبی و صنعتی', 'required' => false],
                'guild_catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'charging-fire-cylenders', 'label' => 'شارژ سیلندرهای آتش نشانی'],
                        ['value' => 'retail', 'label' => 'خرده فروشی'],
                        ['value' => 'sale-and-charging-insdustrial-gas', 'label' => 'فروش و شارژ گازهای صنعتی'],
                        ['value' => 'saling-fire-cylenders', 'label' => 'فروش سیلندرهای آتش نشانی'],
                        ['value' => 'wholesaling-industrial-gas', 'label' => 'عمده فروشی گازهای صنعتی'],
                        ['value' => 'producer', 'label' => 'تولیدکننده'],
                        ['value' => 'unknown', 'label' => 'بدون رسته'],

                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ], 'catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'industrial', 'label' => 'صنعتی'],
                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_or_legal_name' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'status' => ['type' => 'text', 'default' => '', 'disabled' => true],
                'new_status' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'جدید', 'label' => 'جدید'],
                        ['value' => 'درحال بررسی', 'label' => 'در حال بررسی'],
                        ['value' => 'در حال تکمیل', 'label' => 'در حال تکمیل'],
                        ['value' => 'صادر شده', 'label' => 'صادر شده'],
                        ['value' => 'فاقد پروانه', 'label' => 'فاقد پروانه'],
                        ['value' => 'منقضی شده', 'label' => 'منقضی شده'],
                    ]
                ],
                'reviewer' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                    ]
                ],
                'last_referral' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                        ['value' => 'یگانگی', 'label' => 'یگانگی'],
                        ['value' => 'مرادی', 'label' => 'مرادی'],
                        ['value' => 'کیا', 'label' => 'کیا'],
                        ['value' => 'مهموم', 'label' => 'مهموم'],
                        ['value' => 'بایگانی', 'label' => 'بایگانی'],
                    ]
                ],
                'description' => ['type' => 'textarea', 'default' => '', 'required' => false],


            ],
            'memberships' => [
                '96' => ['membership96', 'membership96_pay_date', 'membership96_ref_id', 'membership96_pay_file'],
                'donate96' => ['donate96', 'donate96_pay_date', 'donate96_ref_id', 'donate96_pay_file'],
                'sodur96' => ['sodur96', 'sodur96_pay_date', 'sodur96_ref_id', 'sodur96_pay_file'],

                '97' => ['membership97', 'membership97_pay_date', 'membership97_ref_id', 'membership97_pay_file'],
                'donate97' => ['donate97', 'donate97_pay_date', 'donate97_ref_id', 'donate97_pay_file'],
                'sodur97' => ['sodur97', 'sodur97_pay_date', 'sodur97_ref_id', 'sodur97_pay_file'],

                '98' => ['membership98', 'membership98_pay_date', 'membership98_ref_id', 'membership98_pay_file'],
                'donate98' => ['donate98', 'donate98_pay_date', 'donate98_ref_id', 'donate98_pay_file'],
                'sodur98' => ['sodur98', 'sodur98_pay_date', 'sodur98_ref_id', 'sodur98_pay_file'],

                '99' => ['membership99', 'membership99_pay_date', 'membership99_ref_id', 'membership99_pay_file'],
                'donate99' => ['donate99', 'donate99_pay_date', 'donate99_ref_id', 'donate99_pay_file'],
                'sodur99' => ['sodur99', 'sodur99_pay_date', 'sodur99_ref_id', 'sodur99_pay_file'],

                '00' => ['membership00', 'membership00_pay_date', 'membership00_ref_id', 'membership00_pay_file'],
                'donate00' => ['donate00', 'donate00_pay_date', 'donate00_ref_id', 'donate00_pay_file'],
                'sodur00' => ['sodur00', 'sodur00_pay_date', 'sodur00_ref_id', 'sodur00_pay_file'],

                '01' => ['membership01', 'membership01_pay_date', 'membership01_ref_id', 'membership01_pay_file'],
                'donate01' => ['donate01', 'donate01_pay_date', 'donate01_ref_id', 'donate01_pay_file'],
                'sodur01' => ['sodur01', 'sodur01_pay_date', 'sodur01_ref_id', 'sodur01_pay_file'],

                '02' => ['membership02', 'membership02_pay_date', 'membership02_ref_id', 'membership02_pay_file'],
                'donate02' => ['donate02', 'donate02_pay_date', 'donate02_ref_id', 'donate02_pay_file'],
                'sodur02' => ['sodur02', 'sodur02_pay_date', 'sodur02_ref_id', 'sodur02_pay_file'],

                '03' => ['membership03', 'membership03_pay_date', 'membership03_ref_id', 'membership03_pay_file'],
                'donate03' => ['donate03', 'donate03_pay_date', 'donate03_ref_id', 'donate03_pay_file'],
                'sodur03' => ['sodur03', 'sodur03_pay_date', 'sodur03_ref_id', 'sodur03_pay_file'],

                'donate1' => ['donate1', 'donate1_pay_date', 'donate1_ref_id', 'donate1_pay_file'],
            ],
            'fin_fields' => [
                'fin_details' => ['type' => 'textarea'],
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],

            ],
            'debts' => [
                '1' => ['debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description'],
            ],
            'docs' => [
                'national_card',
                'birth_certificate_image',
                'personal_image',
                'education_degree',
                'military_card',
                'business_rules_certificate',
                'lease_or_ownership_doc',
                'partner_consent_letter',
                'tax',
                'nitrogen_cylinder_hidrostatic_test_certificate',
                'pressure_gauge_calibration_certificate',
                'weightbridge_calibration_certificate',
                'gas_storage_tank_certificate',
                'commitment',
                'revoke_business_license_form',
                'previous_business_license',
                'postal_code_certificate'
            ],
            'foreman' => [
                'foreman_firstname' => ['type' => 'text'],
                'foreman_lastname' => ['type' => 'text'],
                'foreman_national_id' => ['type' => 'text'],
                'foreman_mobile' => ['type' => 'text'],
                'foreman_national_card' => ['type' => 'file'],
                'foreman_birth_certificate_image' => ['type' => 'file'],
                'foreman_personal_image' => ['type' => 'file'],
            ],
            'inspection' => [
                '01' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '02' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '03' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '04' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '05' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
            ],
        ],
        'sale-and-charging-insdustrial-gas' => [
            'name' => 'sale and charging insdustrial gas',
            'catagory_fa' => 'شارژ و فروش گازهای طبی و صنعتی',
            'fields' => [
                'file_number' => ['type' => 'text', 'required' => true],
                'last_request_date' => ['type' => 'text', 'required' => true],
                'last_request_type' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'صدور پروانه', 'label' => 'صدور پروانه'],
                        ['value' => 'تمدید پروانه کسب', 'label' => 'تمدید پروانه کسب'],
                        ['value' => 'تغییر نشانی', 'label' => 'تغییر نشانی'],
                        ['value' => 'تغییر رسته', 'label' => 'تغییر رسته'],
                        ['value' => 'تغییر مالکیت', 'label' => 'تغییر مالکیت'],
                    ]
                ],
                'guild_catagory' => ['type' => 'text', 'disabled' => true, 'default' => 'شارژ و فروش گازهای طبی و صنعتی', 'required' => false],
                'guild_catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'charging-fire-cylenders', 'label' => 'شارژ سیلندرهای آتش نشانی'],
                        ['value' => 'retail', 'label' => 'خرده فروشی'],
                        ['value' => 'sale-and-charging-insdustrial-gas', 'label' => 'فروش و شارژ گازهای صنعتی'],
                        ['value' => 'saling-fire-cylenders', 'label' => 'فروش سیلندرهای آتش نشانی'],
                        ['value' => 'wholesaling-industrial-gas', 'label' => 'عمده فروشی گازهای صنعتی'],
                        ['value' => 'producer', 'label' => 'تولیدکننده'],
                        ['value' => 'unknown', 'label' => 'بدون رسته'],

                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ], 'catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'industrial', 'label' => 'صنعتی'],
                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_or_legal_name' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'status' => ['type' => 'text', 'default' => '', 'disabled' => true],
                'new_status' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'جدید', 'label' => 'جدید'],
                        ['value' => 'درحال بررسی', 'label' => 'در حال بررسی'],
                        ['value' => 'در حال تکمیل', 'label' => 'در حال تکمیل'],
                        ['value' => 'صادر شده', 'label' => 'صادر شده'],
                    ]
                ],
                'reviewer' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                    ]
                ],
                'last_referral' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                        ['value' => 'مهموم', 'label' => 'مهموم'],
                        ['value' => 'کیا', 'label' => 'کیا'],
                        ['value' => 'مرادی', 'label' => 'مرادی'],
                        ['value' => 'یگانگی', 'label' => 'یگانگی'],
                        ['value' => 'بایگانی', 'label' => 'بایگانی'],
                    ]
                ],
                'description' => ['type' => 'textarea', 'default' => '', 'required' => false],

            ],
            'memberships' => [
                '96' => ['membership96', 'membership96_pay_date', 'membership96_ref_id', 'membership96_pay_file'],
                'donate96' => ['donate96', 'donate96_pay_date', 'donate96_ref_id', 'donate96_pay_file'],
                'sodur96' => ['sodur96', 'sodur96_pay_date', 'sodur96_ref_id', 'sodur96_pay_file'],

                '97' => ['membership97', 'membership97_pay_date', 'membership97_ref_id', 'membership97_pay_file'],
                'donate97' => ['donate97', 'donate97_pay_date', 'donate97_ref_id', 'donate97_pay_file'],
                'sodur97' => ['sodur97', 'sodur97_pay_date', 'sodur97_ref_id', 'sodur97_pay_file'],

                '98' => ['membership98', 'membership98_pay_date', 'membership98_ref_id', 'membership98_pay_file'],
                'donate98' => ['donate98', 'donate98_pay_date', 'donate98_ref_id', 'donate98_pay_file'],
                'sodur98' => ['sodur98', 'sodur98_pay_date', 'sodur98_ref_id', 'sodur98_pay_file'],

                '99' => ['membership99', 'membership99_pay_date', 'membership99_ref_id', 'membership99_pay_file'],
                'donate99' => ['donate99', 'donate99_pay_date', 'donate99_ref_id', 'donate99_pay_file'],
                'sodur99' => ['sodur99', 'sodur99_pay_date', 'sodur99_ref_id', 'sodur99_pay_file'],

                '00' => ['membership00', 'membership00_pay_date', 'membership00_ref_id', 'membership00_pay_file'],
                'donate00' => ['donate00', 'donate00_pay_date', 'donate00_ref_id', 'donate00_pay_file'],
                'sodur00' => ['sodur00', 'sodur00_pay_date', 'sodur00_ref_id', 'sodur00_pay_file'],

                '01' => ['membership01', 'membership01_pay_date', 'membership01_ref_id', 'membership01_pay_file'],
                'donate01' => ['donate01', 'donate01_pay_date', 'donate01_ref_id', 'donate01_pay_file'],
                'sodur01' => ['sodur01', 'sodur01_pay_date', 'sodur01_ref_id', 'sodur01_pay_file'],

                '02' => ['membership02', 'membership02_pay_date', 'membership02_ref_id', 'membership02_pay_file'],
                'donate02' => ['donate02', 'donate02_pay_date', 'donate02_ref_id', 'donate02_pay_file'],
                'sodur02' => ['sodur02', 'sodur02_pay_date', 'sodur02_ref_id', 'sodur02_pay_file'],

                '03' => ['membership03', 'membership03_pay_date', 'membership03_ref_id', 'membership03_pay_file'],
                'donate03' => ['donate03', 'donate03_pay_date', 'donate03_ref_id', 'donate03_pay_file'],
                'sodur03' => ['sodur03', 'sodur03_pay_date', 'sodur03_ref_id', 'sodur03_pay_file'],

                'donate1' => ['donate1', 'donate1_pay_date', 'donate1_ref_id', 'donate1_pay_file'],
            ],
            'fin_fields' => [
                'fin_details' => ['type' => 'textarea'],
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],

            ],
            'debts' => [
                '1' => ['debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description'],
            ],
            'docs' => [
                'national_card',
                'birth_certificate_image',
                'personal_image',
                'education_degree',
                'military_card',
                'business_rules_certificate',
                'lease_or_ownership_doc',
                'partner_consent_letter',
                'tax',
                'nitrogen_cylinder_hidrostatic_test_certificate',
                'pressure_gauge_calibration_certificate',
                'weightbridge_calibration_certificate',
                'gas_storage_tank_certificate',
                'commitment',
                'revoke_business_license_form',
                'previous_business_license',
                'postal_code_certificate'
            ],
            'foreman' => [
                'foreman_firstname' => ['type' => 'text'],
                'foreman_lastname' => ['type' => 'text'],
                'foreman_national_id' => ['type' => 'text'],
                'foreman_mobile' => ['type' => 'text'],
                'foreman_national_card' => ['type' => 'file'],
                'foreman_birth_certificate_image' => ['type' => 'file'],
                'foreman_personal_image' => ['type' => 'file'],
            ],
            'inspection' => [
                '01' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '02' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '03' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '04' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '05' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
            ],
        ],
        'saling-fire-cylenders' => [
            'name' => 'saling fire cylenders',
            'catagory_fa' => 'فروش سیلندرهای آتش نشانی',
            'fields' => [
                'file_number' => ['type' => 'text', 'required' => true],
                'last_request_date' => ['type' => 'text', 'required' => true],
                'last_request_type' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'صدور پروانه', 'label' => 'صدور پروانه'],
                        ['value' => 'تمدید پروانه کسب', 'label' => 'تمدید پروانه کسب'],
                        ['value' => 'تغییر نشانی', 'label' => 'تغییر نشانی'],
                        ['value' => 'تغییر رسته', 'label' => 'تغییر رسته'],
                        ['value' => 'تغییر مالکیت', 'label' => 'تغییر مالکیت'],
                    ]
                ],
                'guild_catagory' => ['type' => 'text', 'disabled' => true, 'default' => 'فروش سیلندرهای آتش نشانی', 'required' => false],
                'guild_catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'charging-fire-cylenders', 'label' => 'شارژ سیلندرهای آتش نشانی'],
                        ['value' => 'retail', 'label' => 'خرده فروشی'],
                        ['value' => 'sale-and-charging-insdustrial-gas', 'label' => 'فروش و شارژ گازهای صنعتی'],
                        ['value' => 'saling-fire-cylenders', 'label' => 'فروش سیلندرهای آتش نشانی'],
                        ['value' => 'wholesaling-industrial-gas', 'label' => 'عمده فروشی گازهای صنعتی'],
                        ['value' => 'producer', 'label' => 'تولیدکننده'],
                        ['value' => 'unknown', 'label' => 'بدون رسته'],

                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ], 'catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'industrial', 'label' => 'صنعتی'],
                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_or_legal_name' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'status' => ['type' => 'text', 'default' => '', 'disabled' => true],
                'new_status' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'جدید', 'label' => 'جدید'],
                        ['value' => 'درحال بررسی', 'label' => 'در حال بررسی'],
                        ['value' => 'در حال تکمیل', 'label' => 'در حال تکمیل'],
                        ['value' => 'صادر شده', 'label' => 'صادر شده'],
                    ]
                ],
                'reviewer' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                    ]
                ],
                'last_referral' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                        ['value' => 'مهموم', 'label' => 'مهموم'],
                        ['value' => 'کیا', 'label' => 'کیا'],
                        ['value' => 'مرادی', 'label' => 'مرادی'],
                        ['value' => 'یگانگی', 'label' => 'یگانگی'],
                        ['value' => 'بایگانی', 'label' => 'بایگانی'],
                    ]
                ],
                'description' => ['type' => 'textarea', 'default' => '', 'required' => false],


            ],
            'memberships' => [
                '96' => ['membership96', 'membership96_pay_date', 'membership96_ref_id', 'membership96_pay_file'],
                'donate96' => ['donate96', 'donate96_pay_date', 'donate96_ref_id', 'donate96_pay_file'],
                'sodur96' => ['sodur96', 'sodur96_pay_date', 'sodur96_ref_id', 'sodur96_pay_file'],

                '97' => ['membership97', 'membership97_pay_date', 'membership97_ref_id', 'membership97_pay_file'],
                'donate97' => ['donate97', 'donate97_pay_date', 'donate97_ref_id', 'donate97_pay_file'],
                'sodur97' => ['sodur97', 'sodur97_pay_date', 'sodur97_ref_id', 'sodur97_pay_file'],

                '98' => ['membership98', 'membership98_pay_date', 'membership98_ref_id', 'membership98_pay_file'],
                'donate98' => ['donate98', 'donate98_pay_date', 'donate98_ref_id', 'donate98_pay_file'],
                'sodur98' => ['sodur98', 'sodur98_pay_date', 'sodur98_ref_id', 'sodur98_pay_file'],

                '99' => ['membership99', 'membership99_pay_date', 'membership99_ref_id', 'membership99_pay_file'],
                'donate99' => ['donate99', 'donate99_pay_date', 'donate99_ref_id', 'donate99_pay_file'],
                'sodur99' => ['sodur99', 'sodur99_pay_date', 'sodur99_ref_id', 'sodur99_pay_file'],

                '00' => ['membership00', 'membership00_pay_date', 'membership00_ref_id', 'membership00_pay_file'],
                'donate00' => ['donate00', 'donate00_pay_date', 'donate00_ref_id', 'donate00_pay_file'],
                'sodur00' => ['sodur00', 'sodur00_pay_date', 'sodur00_ref_id', 'sodur00_pay_file'],

                '01' => ['membership01', 'membership01_pay_date', 'membership01_ref_id', 'membership01_pay_file'],
                'donate01' => ['donate01', 'donate01_pay_date', 'donate01_ref_id', 'donate01_pay_file'],
                'sodur01' => ['sodur01', 'sodur01_pay_date', 'sodur01_ref_id', 'sodur01_pay_file'],

                '02' => ['membership02', 'membership02_pay_date', 'membership02_ref_id', 'membership02_pay_file'],
                'donate02' => ['donate02', 'donate02_pay_date', 'donate02_ref_id', 'donate02_pay_file'],
                'sodur02' => ['sodur02', 'sodur02_pay_date', 'sodur02_ref_id', 'sodur02_pay_file'],

                '03' => ['membership03', 'membership03_pay_date', 'membership03_ref_id', 'membership03_pay_file'],
                'donate03' => ['donate03', 'donate03_pay_date', 'donate03_ref_id', 'donate03_pay_file'],
                'sodur03' => ['sodur03', 'sodur03_pay_date', 'sodur03_ref_id', 'sodur03_pay_file'],

                'donate1' => ['donate1', 'donate1_pay_date', 'donate1_ref_id', 'donate1_pay_file'],
            ],
            'fin_fields' => [
                'fin_details' => ['type' => 'textarea'],
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],

            ],
            'debts' => [
                '1' => ['debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description'],
            ],
            'docs' => [
                'national_card',
                'birth_certificate_image',
                'personal_image',
                'education_degree',
                'military_card',
                'business_rules_certificate',
                'lease_or_ownership_doc',
                'partner_consent_letter',
                'tax',
                'nitrogen_cylinder_hidrostatic_test_certificate',
                'pressure_gauge_calibration_certificate',
                'weightbridge_calibration_certificate',
                'gas_storage_tank_certificate',
                'commitment',
                'revoke_business_license_form',
                'previous_business_license',
                'postal_code_certificate'
            ],
            'foreman' => [
                'foreman_firstname' => ['type' => 'text'],
                'foreman_lastname' => ['type' => 'text'],
                'foreman_national_id' => ['type' => 'text'],
                'foreman_mobile' => ['type' => 'text'],
                'foreman_national_card' => ['type' => 'file'],
                'foreman_birth_certificate_image' => ['type' => 'file'],
                'foreman_personal_image' => ['type' => 'file'],
            ],
            'inspection' => [
                '01' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '02' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '03' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '04' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '05' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
            ],
        ],
        'wholesaling-industrial-gas' => [
            'name' => 'wholesaling industrial gas',
            'catagory_fa' => 'عمده فروشی گازهای طبی و صنعتی',
            'fields' => [
                'file_number' => ['type' => 'text', 'required' => true],
                'last_request_date' => ['type' => 'text', 'required' => true],
                'last_request_type' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'صدور پروانه', 'label' => 'صدور پروانه'],
                        ['value' => 'تمدید پروانه کسب', 'label' => 'تمدید پروانه کسب'],
                        ['value' => 'تغییر نشانی', 'label' => 'تغییر نشانی'],
                        ['value' => 'تغییر رسته', 'label' => 'تغییر رسته'],
                        ['value' => 'تغییر مالکیت', 'label' => 'تغییر مالکیت'],
                    ]
                ],
                'guild_catagory' => ['type' => 'text', 'disabled' => true, 'default' => 'عمده فروشی گازهای طبی و صنعتی', 'required' => false],
                'guild_catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'charging-fire-cylenders', 'label' => 'شارژ سیلندرهای آتش نشانی'],
                        ['value' => 'retail', 'label' => 'خرده فروشی'],
                        ['value' => 'sale-and-charging-insdustrial-gas', 'label' => 'فروش و شارژ گازهای صنعتی'],
                        ['value' => 'saling-fire-cylenders', 'label' => 'فروش سیلندرهای آتش نشانی'],
                        ['value' => 'wholesaling-industrial-gas', 'label' => 'عمده فروشی گازهای صنعتی'],
                        ['value' => 'producer', 'label' => 'تولیدکننده'],
                        ['value' => 'unknown', 'label' => 'بدون رسته'],

                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ], 'catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'industrial', 'label' => 'صنعتی'],
                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_or_legal_name' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'status' => ['type' => 'text', 'default' => '', 'disabled' => true],
                'new_status' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'جدید', 'label' => 'جدید'],
                        ['value' => 'درحال بررسی', 'label' => 'در حال بررسی'],
                        ['value' => 'در حال تکمیل', 'label' => 'در حال تکمیل'],
                        ['value' => 'صادر شده', 'label' => 'صادر شده'],
                    ]
                ],
                'reviewer' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                    ]
                ],
                'last_referral' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                        ['value' => 'مهموم', 'label' => 'مهموم'],
                        ['value' => 'کیا', 'label' => 'کیا'],
                        ['value' => 'مرادی', 'label' => 'مرادی'],
                        ['value' => 'یگانگی', 'label' => 'یگانگی'],
                        ['value' => 'بایگانی', 'label' => 'بایگانی'],
                    ]
                ],
                'description' => ['type' => 'textarea', 'default' => '', 'required' => false],


            ],
            'memberships' => [
                '96' => ['membership96', 'membership96_pay_date', 'membership96_ref_id', 'membership96_pay_file'],
                'donate96' => ['donate96', 'donate96_pay_date', 'donate96_ref_id', 'donate96_pay_file'],
                'sodur96' => ['sodur96', 'sodur96_pay_date', 'sodur96_ref_id', 'sodur96_pay_file'],

                '97' => ['membership97', 'membership97_pay_date', 'membership97_ref_id', 'membership97_pay_file'],
                'donate97' => ['donate97', 'donate97_pay_date', 'donate97_ref_id', 'donate97_pay_file'],
                'sodur97' => ['sodur97', 'sodur97_pay_date', 'sodur97_ref_id', 'sodur97_pay_file'],

                '98' => ['membership98', 'membership98_pay_date', 'membership98_ref_id', 'membership98_pay_file'],
                'donate98' => ['donate98', 'donate98_pay_date', 'donate98_ref_id', 'donate98_pay_file'],
                'sodur98' => ['sodur98', 'sodur98_pay_date', 'sodur98_ref_id', 'sodur98_pay_file'],

                '99' => ['membership99', 'membership99_pay_date', 'membership99_ref_id', 'membership99_pay_file'],
                'donate99' => ['donate99', 'donate99_pay_date', 'donate99_ref_id', 'donate99_pay_file'],
                'sodur99' => ['sodur99', 'sodur99_pay_date', 'sodur99_ref_id', 'sodur99_pay_file'],

                '00' => ['membership00', 'membership00_pay_date', 'membership00_ref_id', 'membership00_pay_file'],
                'donate00' => ['donate00', 'donate00_pay_date', 'donate00_ref_id', 'donate00_pay_file'],
                'sodur00' => ['sodur00', 'sodur00_pay_date', 'sodur00_ref_id', 'sodur00_pay_file'],

                '01' => ['membership01', 'membership01_pay_date', 'membership01_ref_id', 'membership01_pay_file'],
                'donate01' => ['donate01', 'donate01_pay_date', 'donate01_ref_id', 'donate01_pay_file'],
                'sodur01' => ['sodur01', 'sodur01_pay_date', 'sodur01_ref_id', 'sodur01_pay_file'],

                '02' => ['membership02', 'membership02_pay_date', 'membership02_ref_id', 'membership02_pay_file'],
                'donate02' => ['donate02', 'donate02_pay_date', 'donate02_ref_id', 'donate02_pay_file'],
                'sodur02' => ['sodur02', 'sodur02_pay_date', 'sodur02_ref_id', 'sodur02_pay_file'],

                '03' => ['membership03', 'membership03_pay_date', 'membership03_ref_id', 'membership03_pay_file'],
                'donate03' => ['donate03', 'donate03_pay_date', 'donate03_ref_id', 'donate03_pay_file'],
                'sodur03' => ['sodur03', 'sodur03_pay_date', 'sodur03_ref_id', 'sodur03_pay_file'],

                'donate1' => ['donate1', 'donate1_pay_date', 'donate1_ref_id', 'donate1_pay_file'],
            ],
            'fin_fields' => [
                'fin_details' => ['type' => 'textarea'],
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],

            ],
            'debts' => [
                '1' => ['debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description'],
            ],
            'docs' => [
                'national_card',
                'birth_certificate_image',
                'personal_image',
                'education_degree',
                'military_card',
                'business_rules_certificate',
                'lease_or_ownership_doc',
                'partner_consent_letter',
                'tax',
                'nitrogen_cylinder_hidrostatic_test_certificate',
                'pressure_gauge_calibration_certificate',
                'weightbridge_calibration_certificate',
                'gas_storage_tank_certificate',
                'commitment',
                'revoke_business_license_form',
                'previous_business_license',
                'postal_code_certificate'
            ],
            'foreman' => [
                'foreman_firstname' => ['type' => 'text'],
                'foreman_lastname' => ['type' => 'text'],
                'foreman_national_id' => ['type' => 'text'],
                'foreman_mobile' => ['type' => 'text'],
                'foreman_national_card' => ['type' => 'file'],
                'foreman_birth_certificate_image' => ['type' => 'file'],
                'foreman_personal_image' => ['type' => 'file'],
            ],
            'inspection' => [
                '01' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '02' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '03' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '04' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '05' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
            ],
        ],
        'producer' => [
            'name' => 'producer',
            'catagory_fa' => 'تولیدکننده',
            'fields' => [
                'file_number' => ['type' => 'text', 'required' => true],
                'last_request_date' => ['type' => 'text', 'required' => true],
                'last_request_type' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'صدور پروانه', 'label' => 'صدور پروانه'],
                        ['value' => 'تمدید پروانه کسب', 'label' => 'تمدید پروانه کسب'],
                        ['value' => 'تغییر نشانی', 'label' => 'تغییر نشانی'],
                        ['value' => 'تغییر رسته', 'label' => 'تغییر رسته'],
                        ['value' => 'تغییر مالکیت', 'label' => 'تغییر مالکیت'],
                    ]
                ],
                'guild_catagory' => ['type' => 'text', 'disabled' => true, 'default' => 'تولیدکننده', 'required' => false],
                'guild_catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'charging-fire-cylenders', 'label' => 'شارژ سیلندرهای آتش نشانی'],
                        ['value' => 'retail', 'label' => 'خرده فروشی'],
                        ['value' => 'sale-and-charging-insdustrial-gas', 'label' => 'فروش و شارژ گازهای صنعتی'],
                        ['value' => 'saling-fire-cylenders', 'label' => 'فروش سیلندرهای آتش نشانی'],
                        ['value' => 'wholesaling-industrial-gas', 'label' => 'عمده فروشی گازهای صنعتی'],
                        ['value' => 'producer', 'label' => 'تولیدکننده'],
                        ['value' => 'unknown', 'label' => 'بدون رسته'],

                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ], 'catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'industrial', 'label' => 'صنعتی'],
                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_or_legal_name' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'status' => ['type' => 'text', 'default' => '', 'disabled' => true],
                'new_status' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'جدید', 'label' => 'جدید'],
                        ['value' => 'درحال بررسی', 'label' => 'در حال بررسی'],
                        ['value' => 'در حال تکمیل', 'label' => 'در حال تکمیل'],
                        ['value' => 'صادر شده', 'label' => 'صادر شده'],
                    ]
                ],
                'reviewer' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                    ]
                ],
                'last_referral' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                        ['value' => 'مهموم', 'label' => 'مهموم'],
                        ['value' => 'کیا', 'label' => 'کیا'],
                        ['value' => 'مرادی', 'label' => 'مرادی'],
                        ['value' => 'یگانگی', 'label' => 'یگانگی'],
                        ['value' => 'بایگانی', 'label' => 'بایگانی'],
                    ]
                ],
                'description' => ['type' => 'textarea', 'default' => '', 'required' => false],

            ],
            'memberships' => [
                '96' => ['membership96', 'membership96_pay_date', 'membership96_ref_id', 'membership96_pay_file'],
                'donate96' => ['donate96', 'donate96_pay_date', 'donate96_ref_id', 'donate96_pay_file'],
                'sodur96' => ['sodur96', 'sodur96_pay_date', 'sodur96_ref_id', 'sodur96_pay_file'],

                '97' => ['membership97', 'membership97_pay_date', 'membership97_ref_id', 'membership97_pay_file'],
                'donate97' => ['donate97', 'donate97_pay_date', 'donate97_ref_id', 'donate97_pay_file'],
                'sodur97' => ['sodur97', 'sodur97_pay_date', 'sodur97_ref_id', 'sodur97_pay_file'],

                '98' => ['membership98', 'membership98_pay_date', 'membership98_ref_id', 'membership98_pay_file'],
                'donate98' => ['donate98', 'donate98_pay_date', 'donate98_ref_id', 'donate98_pay_file'],
                'sodur98' => ['sodur98', 'sodur98_pay_date', 'sodur98_ref_id', 'sodur98_pay_file'],

                '99' => ['membership99', 'membership99_pay_date', 'membership99_ref_id', 'membership99_pay_file'],
                'donate99' => ['donate99', 'donate99_pay_date', 'donate99_ref_id', 'donate99_pay_file'],
                'sodur99' => ['sodur99', 'sodur99_pay_date', 'sodur99_ref_id', 'sodur99_pay_file'],

                '00' => ['membership00', 'membership00_pay_date', 'membership00_ref_id', 'membership00_pay_file'],
                'donate00' => ['donate00', 'donate00_pay_date', 'donate00_ref_id', 'donate00_pay_file'],
                'sodur00' => ['sodur00', 'sodur00_pay_date', 'sodur00_ref_id', 'sodur00_pay_file'],

                '01' => ['membership01', 'membership01_pay_date', 'membership01_ref_id', 'membership01_pay_file'],
                'donate01' => ['donate01', 'donate01_pay_date', 'donate01_ref_id', 'donate01_pay_file'],
                'sodur01' => ['sodur01', 'sodur01_pay_date', 'sodur01_ref_id', 'sodur01_pay_file'],

                '02' => ['membership02', 'membership02_pay_date', 'membership02_ref_id', 'membership02_pay_file'],
                'donate02' => ['donate02', 'donate02_pay_date', 'donate02_ref_id', 'donate02_pay_file'],
                'sodur02' => ['sodur02', 'sodur02_pay_date', 'sodur02_ref_id', 'sodur02_pay_file'],

                '03' => ['membership03', 'membership03_pay_date', 'membership03_ref_id', 'membership03_pay_file'],
                'donate03' => ['donate03', 'donate03_pay_date', 'donate03_ref_id', 'donate03_pay_file'],
                'sodur03' => ['sodur03', 'sodur03_pay_date', 'sodur03_ref_id', 'sodur03_pay_file'],

                'donate1' => ['donate1', 'donate1_pay_date', 'donate1_ref_id', 'donate1_pay_file'],
            ],
            'fin_fields' => [
                'fin_details' => ['type' => 'textarea'],
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],

            ],
            'debts' => [
                '1' => ['debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description'],
            ],
            'docs' => [
                'national_card',
                'birth_certificate_image',
                'personal_image',
                'education_degree',
                'military_card',
                'business_rules_certificate',
                'lease_or_ownership_doc',
                'partner_consent_letter',
                'tax',
                'nitrogen_cylinder_hidrostatic_test_certificate',
                'pressure_gauge_calibration_certificate',
                'weightbridge_calibration_certificate',
                'gas_storage_tank_certificate',
                'commitment',
                'revoke_business_license_form',
                'previous_business_license',
                'postal_code_certificate'
            ],
            'foreman' => [
                'foreman_firstname' => ['type' => 'text'],
                'foreman_lastname' => ['type' => 'text'],
                'foreman_national_id' => ['type' => 'text'],
                'foreman_mobile' => ['type' => 'text'],
                'foreman_national_card' => ['type' => 'file'],
                'foreman_birth_certificate_image' => ['type' => 'file'],
                'foreman_personal_image' => ['type' => 'file'],
            ],
            'inspection' => [
                '01' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '02' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '03' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '04' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '05' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
            ],
        ],
        'unknown' => [
            'name' => 'unknown',
            'catagory_fa' => 'بدون رسته',
            'fields' => [
                'file_number' => ['type' => 'text', 'required' => true],
                'last_request_date' => ['type' => 'text', 'required' => true],
                'last_request_type' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'صدور پروانه', 'label' => 'صدور پروانه'],
                        ['value' => 'تمدید پروانه کسب', 'label' => 'تمدید پروانه کسب'],
                        ['value' => 'تغییر نشانی', 'label' => 'تغییر نشانی'],
                        ['value' => 'تغییر رسته', 'label' => 'تغییر رسته'],
                        ['value' => 'تغییر مالکیت', 'label' => 'تغییر مالکیت'],
                    ]
                ],
                'guild_catagory' => ['type' => 'text', 'disabled' => true, 'default' => 'بدون رسته', 'required' => false],
                'guild_catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'charging-fire-cylenders', 'label' => 'شارژ سیلندرهای آتش نشانی'],
                        ['value' => 'retail', 'label' => 'خرده فروشی'],
                        ['value' => 'sale-and-charging-insdustrial-gas', 'label' => 'فروش و شارژ گازهای صنعتی'],
                        ['value' => 'saling-fire-cylenders', 'label' => 'فروش سیلندرهای آتش نشانی'],
                        ['value' => 'wholesaling-industrial-gas', 'label' => 'عمده فروشی گازهای صنعتی'],
                        ['value' => 'producer', 'label' => 'تولیدکننده'],
                        ['value' => 'unknown', 'label' => 'بدون رسته'],

                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ], 'catagory' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'industrial', 'label' => 'صنعتی'],
                        ['value' => 'safety', 'label' => 'ایمنی'],
                    ]
                ],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_or_legal_name' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'status' => ['type' => 'text', 'default' => '', 'disabled' => true],
                'new_status' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'جدید', 'label' => 'جدید'],
                        ['value' => 'درحال بررسی', 'label' => 'در حال بررسی'],
                        ['value' => 'در حال تکمیل', 'label' => 'در حال تکمیل'],
                        ['value' => 'صادر شده', 'label' => 'صادر شده'],
                    ]
                ],
                'reviewer' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                    ]
                ],
                'last_referral' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'اصفهانی', 'label' => 'اصفهانی'],
                        ['value' => 'اسدی', 'label' => 'اسدی'],
                        ['value' => 'حیدری', 'label' => 'حیدری'],
                        ['value' => 'نعمتی', 'label' => 'نعمتی'],
                        ['value' => 'مقدسی', 'label' => 'مقدسی'],
                        ['value' => 'میرزایی', 'label' => 'میرزایی'],
                        ['value' => 'بام افکن', 'label' => 'بام افکن'],
                        ['value' => 'مهموم', 'label' => 'مهموم'],
                        ['value' => 'کیا', 'label' => 'کیا'],
                        ['value' => 'مرادی', 'label' => 'مرادی'],
                        ['value' => 'یگانگی', 'label' => 'یگانگی'],
                        ['value' => 'بایگانی', 'label' => 'بایگانی'],
                    ]
                ],
                'description' => ['type' => 'textarea', 'default' => '', 'required' => false],


            ],
            'memberships' => [
                '96' => ['membership96', 'membership96_pay_date', 'membership96_ref_id', 'membership96_pay_file'],
                'donate96' => ['donate96', 'donate96_pay_date', 'donate96_ref_id', 'donate96_pay_file'],
                'sodur96' => ['sodur96', 'sodur96_pay_date', 'sodur96_ref_id', 'sodur96_pay_file'],

                '97' => ['membership97', 'membership97_pay_date', 'membership97_ref_id', 'membership97_pay_file'],
                'donate97' => ['donate97', 'donate97_pay_date', 'donate97_ref_id', 'donate97_pay_file'],
                'sodur97' => ['sodur97', 'sodur97_pay_date', 'sodur97_ref_id', 'sodur97_pay_file'],

                '98' => ['membership98', 'membership98_pay_date', 'membership98_ref_id', 'membership98_pay_file'],
                'donate98' => ['donate98', 'donate98_pay_date', 'donate98_ref_id', 'donate98_pay_file'],
                'sodur98' => ['sodur98', 'sodur98_pay_date', 'sodur98_ref_id', 'sodur98_pay_file'],

                '99' => ['membership99', 'membership99_pay_date', 'membership99_ref_id', 'membership99_pay_file'],
                'donate99' => ['donate99', 'donate99_pay_date', 'donate99_ref_id', 'donate99_pay_file'],
                'sodur99' => ['sodur99', 'sodur99_pay_date', 'sodur99_ref_id', 'sodur99_pay_file'],

                '00' => ['membership00', 'membership00_pay_date', 'membership00_ref_id', 'membership00_pay_file'],
                'donate00' => ['donate00', 'donate00_pay_date', 'donate00_ref_id', 'donate00_pay_file'],
                'sodur00' => ['sodur00', 'sodur00_pay_date', 'sodur00_ref_id', 'sodur00_pay_file'],

                '01' => ['membership01', 'membership01_pay_date', 'membership01_ref_id', 'membership01_pay_file'],
                'donate01' => ['donate01', 'donate01_pay_date', 'donate01_ref_id', 'donate01_pay_file'],
                'sodur01' => ['sodur01', 'sodur01_pay_date', 'sodur01_ref_id', 'sodur01_pay_file'],

                '02' => ['membership02', 'membership02_pay_date', 'membership02_ref_id', 'membership02_pay_file'],
                'donate02' => ['donate02', 'donate02_pay_date', 'donate02_ref_id', 'donate02_pay_file'],
                'sodur02' => ['sodur02', 'sodur02_pay_date', 'sodur02_ref_id', 'sodur02_pay_file'],

                '03' => ['membership03', 'membership03_pay_date', 'membership03_ref_id', 'membership03_pay_file'],
                'donate03' => ['donate03', 'donate03_pay_date', 'donate03_ref_id', 'donate03_pay_file'],
                'sodur03' => ['sodur03', 'sodur03_pay_date', 'sodur03_ref_id', 'sodur03_pay_file'],

                'donate1' => ['donate1', 'donate1_pay_date', 'donate1_ref_id', 'donate1_pay_file'],
            ],
            'fin_fields' => [
                'fin_details' => ['type' => 'textarea'],
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],

            ],
            'debts' => [
                '1' => ['debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description'],
            ],
            'docs' => [
                'national_card',
                'birth_certificate_image',
                'personal_image',
                'education_degree',
                'military_card',
                'business_rules_certificate',
                'lease_or_ownership_doc',
                'partner_consent_letter',
                'tax',
                'nitrogen_cylinder_hidrostatic_test_certificate',
                'pressure_gauge_calibration_certificate',
                'weightbridge_calibration_certificate',
                'gas_storage_tank_certificate',
                'commitment',
                'revoke_business_license_form',
                'previous_business_license',
                'postal_code_certificate'
            ],
            'foreman' => [
                'foreman_firstname' => ['type' => 'text'],
                'foreman_lastname' => ['type' => 'text'],
                'foreman_national_id' => ['type' => 'text'],
                'foreman_mobile' => ['type' => 'text'],
                'foreman_national_card' => ['type' => 'file'],
                'foreman_birth_certificate_image' => ['type' => 'file'],
                'foreman_personal_image' => ['type' => 'file'],
            ],
            'inspection' => [
                '01' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '02' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '03' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '04' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
                '05' => ['name' => ['type' => 'text'], 'file' => ['type' => 'file']],
            ],
        ],
    ]
];
