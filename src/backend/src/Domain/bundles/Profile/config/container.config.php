<?php
namespace Domain\Profile;

use Application\Service\CommandService;
use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Domain\Auth\Service\CurrentAccountService;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Profile\Console\Command\ProfileCard;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Entity\ProfileImage;
use Domain\Profile\Middleware\ProfileMiddleware;
use Domain\Profile\Repository\ProfileGreetingsRepository;
use Domain\Profile\Repository\ProfileImageRepository;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Profile\Service\ProfileService;

return [
    'php-di' => [
        ProfileRepository::class => factory(new DoctrineRepositoryFactory(Profile::class)),
        ProfileImageRepository::class => factory(new DoctrineRepositoryFactory(ProfileImage::class)),
        ProfileGreetingsRepository::class => factory(new DoctrineRepositoryFactory(ProfileGreetings::class)),
        ProfileService::class => object()->constructor(
            get(ProfileRepository::class),
            factory(function (Container $container) {
                return sprintf('%s/profile/profile-image', $container->get('config.storage'));
            }),
            get(CollectionRepository::class)
        ),
        ProfileMiddleware::class => object()->constructor(
            get(CommandService::class)
        ),
        ProfileCard::class => object()->constructor(
            get(ProfileService::class)
        ),
    ],
];