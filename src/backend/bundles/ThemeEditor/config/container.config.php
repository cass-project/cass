<?php
namespace ThemeEditor;

use ThemeEditor\Factory\Middleware\ThemeEditorCRUDMiddlewareFactory;
use ThemeEditor\Factory\Service\ThemeEditorServiceFactory;
use ThemeEditor\Middleware\ThemeEditorCRUDMiddleware;
use ThemeEditor\Service\ThemeEditorService;

return [
    'zend_service_manager' => [
        'factories' => [
            ThemeEditorService::class => ThemeEditorServiceFactory::class,
            ThemeEditorCRUDMiddleware::class => ThemeEditorCRUDMiddlewareFactory::class
        ]
    ]
];