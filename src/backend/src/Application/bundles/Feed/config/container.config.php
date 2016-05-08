<?php
namespace Application\Feed;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Feed\Middleware\FeedMiddleware;
use Application\Feed\Service\FeedSourcesService;
use Application\Post\Repository\PostRepository;
use Application\Profile\Repository\ProfileRepository;

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