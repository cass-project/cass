<?php
namespace {
    require __DIR__ . '/../vendor/autoload.php';
}

namespace PhpUnitBootstrap {
    $app = (new \Application\Bootstrap\AppBuilder([
        new \Application\ApplicationBundle(),
        new \Domain\DomainBundle()
    ]))->build();

    /** @var \DI\Container $container */
    $container = $app->getContainer();
    $container->set('config.env', 'test');

    \Application\PHPUnit\TestCase\MiddlewareTestCase::$app = $app;
}