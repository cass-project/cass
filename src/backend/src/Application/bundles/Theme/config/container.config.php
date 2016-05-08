<?php
namespace Application\Theme;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Application\Theme\Entity\Theme;
use Application\Theme\Repository\ThemeRepository;
use Application\Theme\Service\ThemeService;

return [
    'php-di' => [
        ThemeRepository::class => factory(new DoctrineRepositoryFactory(Theme::class)),
        ThemeService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(ThemeRepository::class)
        )
    ]
];