<?php
namespace Domain\Post;

use Domain\Account\Middleware\AccountAppAccessMiddleware;
use Domain\Account\Middleware\AccountMiddleware;
use Zend\Expressive\Application;


return [
    'auth' => [
        [
            'method'     => 'post',
            'url'        => '/protected/account/{command:change-password}',
            'middleware' => AccountMiddleware::class,
            'name'       => 'account-change-password'
        ],
        [
            'method'     => 'put',
            'url'        => '/protected/account/{command:request-delete}',
            'middleware' => AccountMiddleware::class,
            'name'       => 'account-request-delete'
        ],
        [
            'method'     => 'delete',
            'url'        => '/protected/account/{command:cancel-request-delete}',
            'middleware' => AccountMiddleware::class,
            'name'       => 'account-cancel-request-delete'
        ],
        [
            'method'     => 'post',
            'url'        => '/protected/account/{command:switch}/to/profile/{profileId}',
            'middleware' => AccountMiddleware::class,
            'name'       => 'account-switch-to-profile'
        ],
        [
            'method'     => 'get',
            'url'        => '/protected/account/{command:current}',
            'middleware' => AccountMiddleware::class,
            'name'       => 'account-get-current'
        ],
        [
            'method'     => 'get',
            'url'        => '/protected/account/app-access',
            'middleware' => AccountAppAccessMiddleware::class,
            'name'       => 'account-app-access-get'
        ],
    ],
    'common' => [
    ]
];