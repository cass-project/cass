<?php
namespace ThemeEditor;

use ThemeEditor\Middleware\ThemeEditorCRUDMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->post(sprintf('%s/protected/host-admin/theme-editor/{command}/', $prefix), ThemeEditorCRUDMiddleware::class);
};