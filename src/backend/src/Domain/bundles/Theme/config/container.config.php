<?php
namespace Domain\Theme;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Repository\ThemeRepository;

return [
    'php-di' => [
        ThemeRepository::class => factory(new DoctrineRepositoryFactory(Theme::class)),
    ]
];