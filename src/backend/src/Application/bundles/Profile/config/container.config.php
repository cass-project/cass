<?php
namespace Application\Profile;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\Factory\DoctrineRepositoryFactory;
use Application\Profile\Console\Command\ProfileCard;
use Application\Profile\Entity\Profile;
use Application\Profile\Entity\ProfileGreetings;
use Application\Profile\Entity\ProfileImage;
use Application\Profile\Middleware\ProfileMiddleware;
use Application\Profile\Repository\ProfileGreetingsRepository;
use Application\Profile\Repository\ProfileImageRepository;
use Application\Profile\Repository\ProfileRepository;
use Application\Profile\Service\ProfileService;

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