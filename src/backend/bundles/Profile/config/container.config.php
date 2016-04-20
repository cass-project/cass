<?php
use Auth\Service\CurrentAccountService;
use Common\Factory\DoctrineRepositoryFactory;
use Profile\Console\Command\ProfileCard;
use Profile\Entity\Profile;
use Profile\Entity\ProfileGreetings;
use Profile\Entity\ProfileImage;
use Profile\Middleware\ProfileMiddleware;
use Profile\Repository\ProfileGreetingsRepository;
use Profile\Repository\ProfileImageRepository;
use Profile\Repository\ProfileRepository;
use Profile\Service\ProfileService;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        ProfileRepository::class => factory(new DoctrineRepositoryFactory(Profile::class)),
        ProfileImageRepository::class => factory(new DoctrineRepositoryFactory(ProfileImage::class)),
        ProfileGreetingsRepository::class => factory(new DoctrineRepositoryFactory(ProfileGreetings::class)),
        ProfileService::class => object()->constructor(
            get(ProfileRepository::class),
            factory(function(\DI\Container $container) {
                return sprintf('%s/profile/profile-image', $container->get('constants.storage'));
            })
        ),
        ProfileMiddleware::class => object()->constructor(
            get(ProfileService::class),
            get(CurrentAccountService::class)
        ),
        ProfileCard::class => object()->constructor(
            get(ProfileService::class)
        )
    ],
];