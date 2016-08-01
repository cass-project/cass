<?php
namespace Domain\Theme;

use Domain\Theme\Middleware\ThemeMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/theme/{command:create}',
            'middleware' => ThemeMiddleware::class,
            'name'       => 'theme-create'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/theme/{themeId}/{command:delete}',
            'middleware' => ThemeMiddleware::class,
            'name'       => 'theme-delete'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/theme/{themeId}/{command:get}',
            'middleware' => ThemeMiddleware::class,
            'name'       => 'theme-get'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/theme/get/{command:list-all}',
            'middleware' => ThemeMiddleware::class,
            'name'       => 'theme-list-all'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/theme/{themeId}/{command:move}/under/{parentThemeId}/in-position/{position}',
            'middleware' => ThemeMiddleware::class,
            'name'       => 'theme-move'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/theme/get/{command:tree}',
            'middleware' => ThemeMiddleware::class,
            'name'       => 'theme-tree'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/theme/{themeId}/{command:update}',
            'middleware' => ThemeMiddleware::class,
            'name'       => 'theme-update'
        ]
    ]
];