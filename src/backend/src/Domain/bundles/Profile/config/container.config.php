<?php
namespace Domain\Profile;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Entity\ProfileImage;
use Domain\Profile\Repository\ProfileGreetingsRepository;
use Domain\Profile\Repository\ProfileImageRepository;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Profile\Service\ProfileService;

return [
    'php-di' => [
        ProfileRepository::class => factory(new DoctrineRepositoryFactory(Profile::class)),
        ProfileImageRepository::class => factory(new DoctrineRepositoryFactory(ProfileImage::class)),
        ProfileGreetingsRepository::class => factory(new DoctrineRepositoryFactory(ProfileGreetings::class)),
        ProfileService::class => object()
            ->constructorParameter('profileStorageDir', factory(function (Container $container) {
                return sprintf('%s/profile/profile-image', $container->get('config.storage'));
            })),
    ],
];