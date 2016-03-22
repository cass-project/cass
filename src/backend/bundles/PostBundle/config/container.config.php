<?php
namespace Post;

use Post\Factory\Middleware\PostCRUDMIddlewareFactory;
use Post\Factory\Middleware\PostMiddlewareFactory;
use Post\Factory\Service\PostServiceFactory;
use Post\Middleware\PostCRUDMiddleware;
use Post\Middleware\PostMiddleware;
use Post\Service\PostService;

return [
	'zend_service_manager' => [
		'factories' => [
			PostService::class        => PostServiceFactory::class,
			PostMiddleware::class			=> PostMiddlewareFactory::class,
			PostCRUDMiddleware::class => PostCRUDMIddlewareFactory::class,

		]
	]
];