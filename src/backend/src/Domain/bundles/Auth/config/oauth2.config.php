<?php
namespace CASS\Domain\Auth;

return [
    'php-di' => [
        /**
         * This is development keys.
         * Do not use it in production.
         */
        'config.oauth2.google' => [
            'clientId'     => '169665663953-m3rthq2l5fgttjub259f98h74k98nmip.apps.googleusercontent.com',
            'clientSecret' => 'D7ktTED59FXlywru5oMybqlJ',
            'redirectUri'  => 'http://localhost:8080/backend/api/auth/oauth/google',
            'hostedDomain' => 'localhost:8080',
        ],
        'config.oauth2.facebook' => [
            'clientId' => '1029948993728845',
            'clientSecret' => '131f2a99539788aad056f056e0c65801',
            'redirectUri' => 'http://localhost:8080/backend/api/auth/oauth/facebook',
            'graphApiVersion' => 'v2.5'
        ],
        'config.oauth2.battle.net' => [
            'clientId' => '6h3hhxnbzybvhkwt447h7wy82c7t3ebh',
            'clientSecret' => 'HfkdrndubFEEvBwhCGtHUagwQmtPegzp',
            'redirectUri' => 'http://localhost:8080/backend/api/auth/oauth/battle.net',
        ]
    ],
];