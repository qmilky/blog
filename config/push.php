<?php
return [
    'driver' => env('SYSTEM_OS') ? env('SYSTEM_OS') : 'develop',
//    'push_driver' => 'getui',   //使用个推服务
    'push_service' => 'ji_guang', //使用极光服务
    //开发环境
    'develop' => [
        'users' => [
            'getui' => [
                'gt_appid' => 'EqzPeyAa2d7HQDzRhDlPl8',
                'gt_appkey' => 'qujPOl2n6X5PkRAuXKLaY8',
                'gt_appsecret' => 'oLbrUhd0eH6jlyhrvVG039',
                'gt_mastersecret' => 'qFn10OB1x66a9oHdMIF8U3',
                'gt_domainurl' => 'http://sdk.open.api.igexin.com/apiex.htm',
            ],
            //极光配置
            'jiguang' => [
                'gt_appkey' => env('APPS_KEY'),
                'gt_mastersecret' => env('MASTER_SECRET'),
            ],
        ],

        'merchants' => [
            'getui' => [
                'gt_appid' => 'HHTHVKRdjN7h5wxiLUg2z2',
                'gt_appkey' => '3ajAaqzrL69mLGQcky1Kw2',
                'gt_appsecret' => 'lLSlV2w6Je8lGi5BH1HIH2',
                'gt_mastersecret' => '2EN4mnL8aq7HT6oQvVN8o6',
                'gt_domainurl' => 'http://sdk.open.api.igexin.com/apiex.htm',
            ],
            //极光配置
            'jiguang' => [
                'gt_appkey' => env('APPS_KEY'),
                'gt_mastersecret' => env('MASTER_SECRET'),
            ],
        ]

    ],

    //生产环境
    'production' => [
        //个推配置
        'users' => [
            'getui' => [
                'gt_appid' => 'gMwU7UNRrT6CsR1qiRnPo7',
                'gt_appkey' => 'Be2YkxAz1O8nwINk9YCkw8',
                'gt_appsecret' => 'FSpncwFFi87LRkYmEleYh6',
                'gt_mastersecret' => 'gDwtIDo5c1AiPKOz4MhS6A',
                'gt_domainurl' => 'http://sdk.open.api.igexin.com/apiex.htm',
            ],
            //极光配置
            'jiguang' => [
                'gt_appkey' => env('APPS_KEY'),
                'gt_mastersecret' => env('MASTER_SECRET'),
            ],
        ],

        'merchants' => [
            'getui' => [
                'gt_appid' => 'HHTHVKRdjN7h5wxiLUg2z2',
                'gt_appkey' => '3ajAaqzrL69mLGQcky1Kw2',
                'gt_appsecret' => 'lLSlV2w6Je8lGi5BH1HIH2',
                'gt_mastersecret' => '2EN4mnL8aq7HT6oQvVN8o6',
                'gt_domainurl' => 'http://sdk.open.api.igexin.com/apiex.htm',
            ],
            //极光配置
            'jiguang' => [
                'gt_appkey' => env('APPS_KEY'),
                'gt_mastersecret' => env('MASTER_SECRET'),
            ],
        ]


    ]
];
