<?php

return [
    // default signer
    'default' => env('SIGNATURE_DRIVER', 'hmac'),
    'hmac' => [
        'driver' => 'HMAC',
        'options' => [
            // default algo
            'algo' => env('SIGNATURE_HMAC_ALGO', 'sha1'),
            // default hmac key
            'key' => env('SIGNATURE_HMAC_KEY'),
        ],
    ],
    'rsa' => [
        'driver' => 'RSA',
        'options' => [
            //default algo
            'algo' => env('SIGNATURE_RSA_ALGO', 'sha1'),
            // default primary key (if file should be absolute address)
            'publicKey' => env('SIGNATURE_RSA_PUBLIC_KEY'),
            // default primary key (if file should be absolute address)
            'privateKey' => env('SIGNATURE_RSA_PRIVATE_KEY'),
        ],
    ],
    'sign_key' => [
        'worker'      => 'hemodaojiashifu!@#',
        'merchant'   => 'hemodaojiamerchant!@#qwe',
        'zhisheng'   => 'fengxiaobai!@#',
        'system'     => 'yipinxiaobai!@##21',
        'api_gis'    => 'yifengxiaobai!#@!',
        'system_gis' => 'yipinfengxiaobai!#@!',
        'mer_gis' => 'yipinfengxiaobaimer!#@!',
    ],
];
