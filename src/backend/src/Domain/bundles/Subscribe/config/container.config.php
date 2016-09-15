<?php
namespace CASS\Domain\Bundles\Subscribe;

use function \DI\factory;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Repository\SubscribeRepository;

return [
    'php-di' => [
        SubscribeRepository::class => factory(new DoctrineRepositoryFactory(Subscribe::class) )
    ]
];