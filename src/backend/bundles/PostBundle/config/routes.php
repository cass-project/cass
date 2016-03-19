<?php

namespace Application;


use Zend\Expressive\Application;

return function(Application $app, string $prefix){
	$app->put(
		sprintf('%s/protected/post/{command:create}', $prefix),
		ChannelCRUDMiddleware::class,
		'channel-create'
	);
};