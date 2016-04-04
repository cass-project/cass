<?php
namespace Post;

use Post\Factory\Middleware\PostAttachmentMiddlewareFactory;
use Post\Factory\Middleware\PostCRUDMIddlewareFactory;
use Post\Factory\Middleware\PostMiddlewareFactory;
use Post\Factory\Service\AttachmentServiceFactory;
use Post\Factory\Service\PostServiceFactory;
use Post\Middleware\PostAttachmentMiddleware;
use Post\Middleware\PostCRUDMiddleware;
use Post\Middleware\PostMiddleware;
use Post\Service\AttachmentService;
use Post\Service\PostService;

return [
	'zend_service_manager' => [
		'factories' => [
			PostService::class              => PostServiceFactory::class,
			AttachmentService::class				=> AttachmentServiceFactory::class,
			PostMiddleware::class           => PostMiddlewareFactory::class,
			PostAttachmentMiddleware::class => PostAttachmentMiddlewareFactory::class
		]
	]
];