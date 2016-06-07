<?php
namespace Domain\ProfileIM;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\ProfileIM\Repository\ProfileMessageRepository;

return [
    'php-di' => [
        ProfileMessageRepository::class => factory(new DoctrineRepositoryFactory(\Domain\ProfileIM\Entity\ProfileMessage::class))
    ]
];