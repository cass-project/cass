<?php

use Auth\Service\CurrentAccountService;
use Common\Factory\DoctrineRepositoryFactory;
use Post\Entity\Post;
use Post\Middleware\PostMiddleware;
use Post\PostRepository;

use function DI\object;
use function DI\factory;
use function DI\get;
use Post\Service\PostService;

return [
    'php-di' => [
        PostRepository::class => (new DoctrineRepositoryFactory(Post::class)),
        PostService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(PostRepository::class)
        ),
        PostMiddleware::class => object()->constructor(
            get(CurrentAccountService::class),
            get(PostService::class)
        )
    ]
];