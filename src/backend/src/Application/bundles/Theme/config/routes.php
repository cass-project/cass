<?php
namespace Application\Theme;

use Application\Theme\Middleware\ThemeMiddleware;
use Zend\Expressive\Application;

return function (Application $app, string $prefix) {
    $app->put(
        sprintf('%s/protected/theme/{command:create}', $prefix),
        ThemeMiddleware::class,
        'theme-create'
    );

    $app->delete(
        sprintf('%s/protected/theme/{themeId}/{command:delete}', $prefix),
        ThemeMiddleware::class,
        'theme-delete'
    );

    $app->get(
        sprintf('%s/theme/{themeId}/{command:get}', $prefix),
        ThemeMiddleware::class,
        'theme-get'
    );

    $app->get(
        sprintf('%s/theme/get/{command:list-all}', $prefix),
        ThemeMiddleware::class,
        'theme-list-all'
    );

    $app->post(
        sprintf('%s/protected/theme/{themeId}/{command:move}/under/{parentThemeId}/in-position/{position}', $prefix),
        ThemeMiddleware::class,
        'theme-move'
    );

    $app->get(
        sprintf('%s/theme/get/{command:tree}', $prefix),
        ThemeMiddleware::class,
        'theme-tree'
    );

    $app->post(
        sprintf('%s/protected/theme/{themeId}/{command:update}', $prefix),
        ThemeMiddleware::class,
        'theme-update'
    );
};