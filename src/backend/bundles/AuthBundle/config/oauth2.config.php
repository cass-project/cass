<?php
return [
    /**
     * This is development keys.
     * Do not use it in production.
     */
    'oauth2_providers' => [
        'vk' => [
            'clientId' => '5289954',
            'clientSecret' => 'BXjBPK8sdfYoFcYPUArK',
            'redirectUri' => 'http://localhost:8080/backend/api/auth/oauth/vk',
            'v' => 5.45
        ],
        'mailru' => [
            'clientId' => '741989',
            'clientSecret' => '624101a79a67e6918ea420338de3002f',
            'redirectUri' => 'http://localhost:8080/backend/api/auth/oauth/mailru',
        ],
        'yandex' => [
            'clientId'     => '37ba46dfecd8464f8298612ecb5641ff',
            'clientSecret' => '20177d8b3379445ead1e262a3ffa76ee',
            'redirectUri'  => 'http://localhost:8080/backend/api/auth/oauth/yandex',
        ],
        'google' => [
            'clientId'     => '169665663953-m3rthq2l5fgttjub259f98h74k98nmip.apps.googleusercontent.com',
            'clientSecret' => 'D7ktTED59FXlywru5oMybqlJ',
            'redirectUri'  => 'http://localhost:8080/backend/api/auth/oauth/google',
            'hostedDomain' => 'localhost:8080',
        ],
        'facebook' => [
            'clientId' => '1029948993728845',
            'clientSecret' => '131f2a99539788aad056f056e0c65801',
            'redirectUri' => 'http://localhost:8080/backend/api/auth/oauth/facebook',
            'graphApiVersion' => 'v2.5'
        ]
    ]
];