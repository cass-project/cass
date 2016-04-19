<?php
use Auth\Service\CurrentAccountService;
use Common\Factory\DoctrineRepositoryFactory;
use Theme\Entity\Theme;
use Theme\Repository\ThemeRepository;

use function DI\object;
use function DI\factory;
use function DI\get;
use Theme\Service\ThemeService;

return [
    'php-di' => [
        ThemeRepository::class => factory(new DoctrineRepositoryFactory(Theme::class)),
        ThemeService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(ThemeRepository::class)
        )
    ]
];