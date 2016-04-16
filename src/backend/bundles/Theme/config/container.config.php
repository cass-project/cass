<?php
use Common\Factory\DoctrineRepositoryFactory;
use Theme\Entity\Theme;
use Theme\Repository\ThemeRepository;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        ThemeRepository::class => factory(new DoctrineRepositoryFactory(Theme::class))
    ]
];