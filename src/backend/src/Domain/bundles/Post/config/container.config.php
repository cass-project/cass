<?php
namespace CASS\Domain\Bundles\Post;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Post\Entity\PostThemeEQ;
use CASS\Domain\Bundles\Post\Repository\PostRepository;
use CASS\Domain\Bundles\Post\Repository\PostThemeEQRepository;

return [
    'php-di' => [
        PostRepository::class => factory(new DoctrineRepositoryFactory(Post::class)),
        PostThemeEQRepository::class => factory(new DoctrineRepositoryFactory(PostThemeEQ::class)),
    ]
];