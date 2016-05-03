<?php
namespace Feed;

use Feed\Middleware\FeedMiddleware;
use Feed\Service\FeedSourcesService;


use function DI\object;
use function DI\factory;
use function DI\get;
use Post\Repository\PostRepository;
use Profile\Repository\ProfileRepository;

return [
    'php-di' => [
        FeedSourcesService::class => object()->constructor(
            get(PostRepository::class),
            get(ProfileRepository::class)
        ),
        FeedMiddleware::class => object()->constructor(
            get(FeedSourcesService::class)
        ),
    ]
];