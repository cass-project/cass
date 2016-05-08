<?php
namespace Application\Post;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Application\Post\Entity\Post;
use Application\Post\Middleware\PostMiddleware;
use Application\Post\Repository\PostRepository;
use Application\Post\Service\PostService;
use Application\PostAttachment\Service\PostAttachmentService;

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