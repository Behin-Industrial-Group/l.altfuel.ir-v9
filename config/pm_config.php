<?php 

return [
    'debug' => env('APP_DEBUG', false),
    'process' => [
        [
            'id' => "20109551764e348a7a8c913045934777",
            'name' => 'درخواست مرخصی',
            'case' => [
                [ 
                    'id' => "45908983164e349077ed031067620029",
                    'name' => 'ثبت درخواست',  
                    'dynamic_view_form' => 'register',
                    'trigger' => 
                    [
                        [ 'name' => 'set user id', 'id' => '68379534364e3501fd57709063851566' ],
                        [ 'name' => 'set name of requester', 'id' => '98954906564e3553a082989062656447' ]
                    ]
                ],
            ],
        ]
    ],
];