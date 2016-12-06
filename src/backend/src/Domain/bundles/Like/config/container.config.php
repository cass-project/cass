<?php
namespace CASS\Domain\Bundles\Like;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Repository\LikeRepository\LikeRepository;
use function \DI\factory;
use function \DI\get;

return [
    'php-di' => [
        LikeRepository::class => factory(new DoctrineRepositoryFactory(Attitude::class)),
    ],
];