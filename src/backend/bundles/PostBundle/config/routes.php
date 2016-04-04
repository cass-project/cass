<?php

namespace Application;


use Post\Middleware\AttachmentMiddleware;
use Post\Middleware\PostMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix){
	$app->put(
		sprintf('%s/protected/post/{command:create}', $prefix),
		PostMiddleware::class,
		'post-create'
	);

	$app->get(
		sprintf('%s/protected/post/{command:read}', $prefix),
		PostMiddleware::class,
		'post-read'
	);
	$app->get(
		sprintf('%s/protected/post/{command:read}/{postId}', $prefix),
		PostMiddleware::class,
		'post-read-entity'
	);
	$app->post(
		sprintf('%s/protected/post/{command:update}', $prefix),
		PostMiddleware::class,
		'post-update-entity'
	);
	$app->post(
		sprintf('%s/protected/post/{command:delete}/{postId}', $prefix),
		PostMiddleware::class,
		'post-update-entity'
	);



	$app->post(
		sprintf('%s/protected/post/attachment/{command:add}', $prefix),
		AttachmentMiddleware::class,
		'post-add-attachment'
	);
	$app->post(
		sprintf('%s/protected/post/attachment/{command:delete}/attachmentId', $prefix),
		AttachmentMiddleware::class,
		'post-delete-attachment'
	);



	// post persist


	$app->post(
		sprintf('%s/protected/post/link/{command:parse}', $prefix),
		PostMiddleware::class,
		'link-parse'
	);



};