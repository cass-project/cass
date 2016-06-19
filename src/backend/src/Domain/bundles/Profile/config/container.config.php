<?php
namespace Domain\Profile;

use function DI\object;
use function DI\factory;
use function DI\get;

use DI\Container;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Profile\Service\ProfileService;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

return [
    'php-di' => [
        'config.paths.profile.avatar.dir' => factory(function(Container $container) {
            return sprintf('%s/profile/by-sid/avatar/', $container->get('config.paths.assets.dir'));
        }),
        ProfileRepository::class => factory(new DoctrineRepositoryFactory(Profile::class)),
        ProfileService::class => object()
            ->constructorParameter('imageFlySystem', factory(function(Container $container) {
                return new Filesystem(new Local($container->get('config.paths.profile.avatar.dir')));
            })),
    ],
];