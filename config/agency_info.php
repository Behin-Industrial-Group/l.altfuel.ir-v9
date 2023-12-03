<?php

return [
    'fin_uploads' => 'fin_uploads',
    'valid_file_type' => ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'],
    'main_field_name' => 'customer_type',
    'default_fields' => ['customer_type','firstname', 'lastname', 'national_id', 'agency_code'],
    'filter_fields' => [
        'customer_type','firstname', 'lastname', 'national_id', 'agency_code',
        'address', 'guild_number', 'mobile', 'phone', 'issued_date', 'exp_date', 'description',
        'province', 'agency_code', 'membership_96', 'membership_97', 'membership_98',
        'membership_99', 'membership_00', 'membership_01', 'membership_02', 'debt1'
    ],
    'customer_type' => [
        'agency' => [
            'name' => 'High Pressure Agency',
            'fields' => [
                'enable' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => '1', 'label' => 'فعال'],
                        ['value' => '0', 'label' => 'غیرفعال'],
                    ]
                ],
                'customer_type' => ['type' => 'text', 'default' => '', 'required' => false],
                'receiving_code_year' => ['type' => 'text'],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'agency_code' => ['type' => 'text'],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'exp_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'address' => ['type' => 'text', 'default' => ''],
                'postal_code' => ['type' => 'text'],
                'location' => ['type' => 'text', 'default' => ''],
                'description' => ['type' => 'text', 'default' => '', 'required' => false],
                'inspection_user' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => '0', 'label' => 'تحویل نشده است'],
                        ['value' => '1', 'label' => 'تحویل داده شد'],
                    ]
                ],
                

            ],
            'memberships' => [
                '96' => ['membership_96', 'membership_96_pay_date', 'membership_96_ref_id', 'membership_96_pay_file'],
                '97' => ['membership_97', 'membership_97_pay_date', 'membership_97_ref_id', 'membership_97_pay_file'],
                '98' => ['membership_98', 'membership_98_pay_date', 'membership_98_ref_id', 'membership_98_pay_file'],
                '99' => ['membership_99', 'membership_99_pay_date', 'membership_99_ref_id', 'membership_99_pay_file'],
                '00' => ['membership_00', 'membership_00_pay_date', 'membership_00_ref_id', 'membership_00_pay_file'],
                '01' => ['membership_01', 'membership_01_pay_date', 'membership_01_ref_id', 'membership_01_pay_file'],
                '02' => ['membership_02', 'membership_02_pay_date', 'membership_02_ref_id', 'membership_02_pay_file'],
                'irngv' => ['irngv', 'irngv_pay_date', 'irngv_ref_id', 'irngv_pay_file'],
                'plate_reader' => ['plate_reader', 'plate_reader_pay_date', 'plate_reader_ref_id', 'plate_reader_pay_file'],
            ],
            'fin_fields' => [
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],
                
            ],
            'docs' => [
                'archive_docs',
            ],
            'debts' => [
                '1' => [ 'debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description' ],
            ]
        ],
        'low-pressure' => [
            'name' => 'Low Pressure Agency',
            'fields' => [
                'enable' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => '1', 'label' => 'فعال'],
                        ['value' => '0', 'label' => 'غیرفعال'],
                    ]
                ],
                'customer_type' => ['type' => 'text', 'default' => '', 'required' => false],
                'receiving_code_year' => ['type' => 'text'],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'agency_code' => ['type' => 'text'],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'exp_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'address' => ['type' => 'text', 'default' => ''],
                'postal_code' => ['type' => 'text'],
                'location' => ['type' => 'text', 'default' => ''],
                'description' => ['type' => 'text', 'default' => '', 'required' => false],
                'inspection_user' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => '0', 'label' => 'تحویل نشده است'],
                        ['value' => '1', 'label' => 'تحویل داده شد'],
                    ]
                ],
            ],
            'memberships' => [
                '96' => ['membership_96', 'membership_96_pay_date', 'membership_96_ref_id', 'membership_96_pay_file'],
                '97' => ['membership_97', 'membership_97_pay_date', 'membership_97_ref_id', 'membership_97_pay_file'],
                '98' => ['membership_98', 'membership_98_pay_date', 'membership_98_ref_id', 'membership_98_pay_file'],
                '99' => ['membership_99', 'membership_99_pay_date', 'membership_99_ref_id', 'membership_99_pay_file'],
                '00' => ['membership_00', 'membership_00_pay_date', 'membership_00_ref_id', 'membership_00_pay_file'],
                '01' => ['membership_01', 'membership_01_pay_date', 'membership_01_ref_id', 'membership_01_pay_file'],
                '02' => ['membership_02', 'membership_02_pay_date', 'membership_02_ref_id', 'membership_02_pay_file'],
            ],
            'fin_fields' => [
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],
                
            ],
            'docs' => [
                'archive_docs',
            ],
            'debts' => [
                '1' => [ 'debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description' ],
            ]
        ],
        'hidrostatic' => [
            'name' => 'Hidrostatic Laboratory',
            'fields' => [
                'enable' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => '1', 'label' => 'فعال'],
                        ['value' => '0', 'label' => 'غیرفعال'],
                    ]
                ],
                'customer_type' => ['type' => 'text', 'default' => '', 'required' => false],
                'receiving_code_year' => ['type' => 'text'],
                'firstname' => ['type' => 'text', 'default' => '', 'required' => false],
                'lastname' => ['type' => 'text', 'default' => '', 'required' => false],
                'national_id' => ['type' => 'text', 'default' => '', 'required' => false],
                'agency_code' => ['type' => 'text'],
                'mobile' => ['type' => 'text', 'default' => '', 'required' => false],
                'phone' => ['type' => 'text', 'default' => '', 'required' => false],
                'guild_number' => ['type' => 'text', 'default' => '', 'required' => false],
                'issued_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'exp_date' => ['type' => 'text', 'default' => '', 'required' => false],
                'province' => ['type' => 'select', 'default' => '', 'options' => '', 'option-url' => 'city.all'],
                'address' => ['type' => 'text', 'default' => ''],
                'postal_code' => ['type' => 'text'],
                'location' => ['type' => 'text', 'default' => ''],
                'description' => ['type' => 'text', 'default' => '', 'required' => false],
                'inspection_user' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => '0', 'label' => 'تحویل نشده است'],
                        ['value' => '1', 'label' => 'تحویل داده شد'],
                    ]
                ],
            ],
            'further_information' => [
                'simfa_code' => ['type' => 'text'],
                'legal_national_id' => ['type' => 'text'],
                'standard_certificate_exp_date' => ['type' => 'text'],
                'standard_certificate_number' => ['type' => 'text'],
            ],
            'memberships' => [
                '96' => ['membership_96', 'membership_96_pay_date', 'membership_96_ref_id', 'membership_96_pay_file'],
                '97' => ['membership_97', 'membership_97_pay_date', 'membership_97_ref_id', 'membership_97_pay_file'],
                '98' => ['membership_98', 'membership_98_pay_date', 'membership_98_ref_id', 'membership_98_pay_file'],
                '99' => ['membership_99', 'membership_99_pay_date', 'membership_99_ref_id', 'membership_99_pay_file'],
                '00' => ['membership_00', 'membership_00_pay_date', 'membership_00_ref_id', 'membership_00_pay_file'],
                '01' => ['membership_01', 'membership_01_pay_date', 'membership_01_ref_id', 'membership_01_pay_file'],
                '02' => ['membership_02', 'membership_02_pay_date', 'membership_02_ref_id', 'membership_02_pay_file'],
                'irngv' => ['irngv', 'irngv_pay_date', 'irngv_ref_id', 'irngv_pay_file'],
            ],
            'fin_fields' => [
                'fin_green' => [
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        ['value' => 'not ok', 'label' => 'غیرفعال'],
                        ['value' => 'ok', 'label' => 'فعال'],
                    ]
                ],
                
            ],
            'docs' => [
                'archive_docs',
            ],
            'debts' => [
                '1' => [ 'debt1', 'debt1_pay_date', 'debt1_ref_id', 'debt1_description' ],
            ],

            'simfa_fields' => [
                'simfa_code'                    =>['type' => 'text'],
                'legal_national_id'             =>['type' => 'text'],
                'standard_certificate_exp_date' =>['type' => 'text'],
                'standard_certificate_number'   =>['type' => 'text'],
            ]
        ],
    ]
];
