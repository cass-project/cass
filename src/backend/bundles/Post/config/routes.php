<?php

namespace Common;


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
		'post-entity-read'
	);
	$app->post(
		sprintf('%s/protected/post/{command:update}', $prefix),
		PostMiddleware::class,
		'post-entity-update'
	);
	$app->delete(
		sprintf('%s/protected/post/{command:delete}/{postId}', $prefix),
		PostMiddleware::class,
		'post-entity-delete'
	);

	/*
	 * =========== Attachments ===========
	 */

	$app->put(
		sprintf('%s/protected/post/attachment/{command:add}', $prefix),
		AttachmentMiddleware::class,
		'post-attachment-add'
	);

	$app->post(
		sprintf('%s/protected/post/attachment/{command:delete}/attachmentId', $prefix),
		AttachmentMiddleware::class,
		'post-attachment-delete'
	);

	//post persist saves persis post
	$app->post(
		sprintf('%s/protected/post/link/{command:parse}', $prefix),
		PostMiddleware::class,
		'link-parse'
	);



};