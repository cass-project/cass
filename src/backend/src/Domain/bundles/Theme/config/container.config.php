<?php
namespace Domain\Theme;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Repository\ThemeRepository;
use Domain\Theme\Service\ThemeService;

return [
    'php-di' => [
        ThemeRepository::class => factory(new DoctrineRepositoryFactory(Theme::class)),
        ThemeService::class => object()->constructor(
            get(CurrentAccountService::class),
            get(ThemeRepository::class)
        )
    ]
];