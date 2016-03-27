<?php

namespace Application;


use Post\Middleware\PostCRUDMiddleware;
use Post\Middleware\PostMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix){
	$app->put(
		sprintf('%s/protected/post/{command:create}', $prefix),
		PostCRUDMiddleware::class,
		'post-create'
	);

	$app->get(
		sprintf('%s/protected/post/{command:read}', $prefix),
		PostCRUDMiddleware::class,
		'post-read'
	);
	$app->get(
		sprintf('%s/protected/post/{command:read}/{postId}', $prefix),
		PostCRUDMiddleware::class,
		'post-read-entity'
	);
	$app->post(
		sprintf('%s/protected/post/{command:update}', $prefix),
		PostCRUDMiddleware::class,
		'post-update-entity'
	);

	$app->post(
		sprintf('%s/protected/post/link/{command:parse}', $prefix),
		PostMiddleware::class,
		'link-parse'
	);
};