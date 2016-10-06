<?php
namespace CASS\Chat;

use CASS\Chat\Entity\Message;
use CASS\Chat\Repository\MessageRepository;
use function \DI\factory;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
    'php-di' => [
        MessageRepository::class => factory(new DoctrineRepositoryFactory(Message::class) )
    ]
];