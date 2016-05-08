<?php
namespace Domain\Post;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Service\CurrentAccountService;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Post\Entity\Post;
use Domain\Post\Middleware\PostMiddleware;
use Domain\Post\Repository\PostRepository;
use Domain\Post\Service\PostService;
use Domain\PostAttachment\Service\PostAttachmentService;

return [
    'php-di' => [
        PostRepository::class => factory(new DoctrineRepositoryFactory(Post::class)),
        PostService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(PostAttachmentService::class),
            get(PostRepository::class)
        ),
        PostMiddleware::class => object()->constructor(
            get(CurrentAccountService::class),
            get(PostService::class)
        )
    ]
];