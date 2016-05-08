<?php
namespace Domain\Feed;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Feed\Middleware\FeedMiddleware;
use Domain\Feed\Service\FeedSourcesService;
use Domain\Post\Repository\PostRepository;
use Domain\Profile\Repository\ProfileRepository;

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