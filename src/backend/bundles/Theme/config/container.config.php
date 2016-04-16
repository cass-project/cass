<?php
use Doctrine\ORM\EntityManager;
use Theme\Repository\ThemeRepository;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        ThemeRepository::class => factory([EntityManager::class, 'getRepository'])
    ]
];