<?php

namespace Application;


use Post\Middleware\PostCRUDMiddleware;
use Post\Middleware\PostMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix){
	$app->put(
		sprintf('%s/protected/post/{command:create}', $prefix),
		PostCRUDMiddleware::class,
		'channel-create'
	);
	$app->post(
		sprintf('%s/protected/post/link/{command:parse}', $prefix),
		PostMiddleware::class,
		'link-parse'
	);
};