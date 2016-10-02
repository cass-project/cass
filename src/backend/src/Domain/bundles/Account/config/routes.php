<?php
namespace CASS\Domain\Bundles\Post;

use CASS\Domain\Bundles\Account\Middleware\AccountAppAccessMiddleware;
use CASS\Domain\Bundles\Account\Middleware\AccountMiddleware;

return [
    'auth' => [
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/account/{command:change-password}[/]',
            'middleware' => AccountMiddleware::class,
            'name' => 'account-change-password',
        ],
        [
            'type' => 'route',
            'method' => 'put',
            'url' => '/protected/account/{command:request-delete}[/]',
            'middleware' => AccountMiddleware::class,
            'name' => 'account-request-delete',
        ],
        [
            'type' => 'route',
            'method' => 'delete',
            'url' => '/protected/account/{command:cancel-request-delete}[/]',
            'middleware' => AccountMiddleware::class,
            'name' => 'account-cancel-request-delete',
        ],
        [
            'type' => 'route',
            'method' => 'post',
            'url' => '/protected/account/{command:switch}/to/profile/{profileId}[/]',
            'middleware' => AccountMiddleware::class,
            'name' => 'account-switch-to-profile',
        ],
        [
            'type' => 'route',
            'method' => 'get',
            'url' => '/protected/account/{command:current}[/]',
            'middleware' => AccountMiddleware::class,
            'name' => 'account-get-current',
        ],
        [
            'type' => 'route',
            'method' => 'get',
            'url' => '/protected/account/app-access[/]',
            'middleware' => AccountAppAccessMiddleware::class,
            'name' => 'account-app-access-get',
        ],
    ],
    'common' => [
    ],
];