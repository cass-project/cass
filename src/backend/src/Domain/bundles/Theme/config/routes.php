<?php
namespace Domain\Theme;

use Domain\Theme\Middleware\ThemeMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->put(
        '/protected/theme/{command:create}',
        ThemeMiddleware::class,
        'theme-create'
    );

    $app->delete(
        '/protected/theme/{themeId}/{command:delete}',
        ThemeMiddleware::class,
        'theme-delete'
    );

    $app->get(
        '/theme/{themeId}/{command:get}',
        ThemeMiddleware::class,
        'theme-get'
    );

    $app->get(
        '/theme/get/{command:list-all}',
        ThemeMiddleware::class,
        'theme-list-all'
    );

    $app->post(
        '/protected/theme/{themeId}/{command:move}/under/{parentThemeId}/in-position/{position}',
        ThemeMiddleware::class,
        'theme-move'
    );

    $app->get(
        '/theme/get/{command:tree}',
        ThemeMiddleware::class,
        'theme-tree'
    );

    $app->post(
        '/protected/theme/{themeId}/{command:update}',
        ThemeMiddleware::class,
        'theme-update'
    );
};